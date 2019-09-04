<?php
/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace SAREhub\MicroORM\Entity;


use Doctrine\DBAL\Driver\Statement;

class EntityCursor implements \Iterator
{

    /**
     * @var EntityRepository
     */
    private $repo;

    /**
     * @var \Iterator
     */
    private $it;

    public function __construct(EntityRepository $repo, Statement $st)
    {
        $this->repo = $repo;
        $st->setFetchMode(\PDO::FETCH_ASSOC);
        $this->it = new \IteratorIterator($st);
    }

    public function current()
    {
        $data = $this->getIterator()->current();
        return $this->createFromArray($data);
    }

    public function next()
    {
        $this->getIterator()->next();
    }

    public function key()
    {
        return $this->getIterator()->key();
    }

    public function valid()
    {
        return $this->getIterator()->valid();
    }

    public function rewind()
    {
        $this->getIterator()->rewind();
    }

    private function createFromArray(array $data): Entity
    {
        return $this->repo->createFromArray($data);
    }

    private function getIterator(): \Iterator
    {
        return $this->it;
    }
}