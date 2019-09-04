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

namespace SAREhub\MicroORM\Manager;


class PrefixedDatabaseManager implements DatabaseManager
{
    /**
     * @var DatabaseManager
     */
    private $decorated;

    /**
     * @var string
     */
    private $prefix;


    public function __construct(string $prefix, DatabaseManager $decorated)
    {
        $this->decorated = $decorated;
        $this->prefix = $prefix;
    }

    public function create(string $name, ?CreateDatabaseOptions $options = null): void
    {
        $this->decorated->create($this->getPrefixed($name), $options);
    }

    public function drop(string $name): void
    {
        $this->decorated->drop($this->getPrefixed($name));
    }

    public function exists(string $name): bool
    {
        return $this->decorated->exists($this->getPrefixed($name));
    }

    public function getList(): array
    {
        $list = [];
        foreach ($this->decorated->getList() as $name) {
            if ($this->hasPrefix($name)) {
                $list[] = $this->stripPrefix($name);
            }
        }
        return $list;
    }

    private function getPrefixed(string $name): string
    {
        return $this->prefix . $name;
    }

    private function hasPrefix(string $name)
    {
        return strpos($name, $this->prefix) === 0;
    }

    private function stripPrefix(string $name)
    {
        return substr($name, strlen($this->prefix));
    }
}