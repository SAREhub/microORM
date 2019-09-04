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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use SAREhub\MicroORM\Pagination\PageInfo;

abstract class EntityRepository
{

    const ASC_ORDER = 'ASC';
    const DESC_ORDER = 'DESC';

    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Entity|mixed $entity
     * @throws DBALException
     */
    public function save($entity)
    {
        if ($entity->hasId()) {
            $this->update($entity);
        } else {
            $this->insert($entity);
        }
    }

    /**
     * @param Entity|mixed $entity
     * @throws DBALException
     */
    protected function insert($entity)
    {
        $data = $this->prepareForInsertUpdate($entity);
        $this->getConnection()->insert($this->getTable(), $data, $this->getColumnTypes());
        $entity->setId($this->getConnection()->lastInsertId());
    }

    /**
     * @param Entity|mixed $entity
     * @throws DBALException
     */
    protected function update($entity)
    {
        $data = $this->prepareForInsertUpdate($entity);
        $search = [Entity::ID_ENTRY => $entity->getId()];
        $this->getConnection()->update($this->getTable(), $data, $search, $this->getColumnTypes());
    }

    protected function prepareForInsertUpdate(Entity $entity): array
    {
        $data = [];
        foreach ($entity->getAllForInsertUpdate() as $col => $val) {
            $quotedCol = $this->getConnection()->quoteIdentifier($col);
            $data[$quotedCol] = $val;
        }
        return $data;
    }

    /**
     * @param $id
     * @return Entity
     * @throws EntityNotFoundException
     */
    public function findById($id)
    {
        $result = $this->getManager()->getConnection()->createQueryBuilder()
            ->select('*')
            ->from($this->getTable())
            ->where('id = ?')
            ->setParameter(0, $id, static::getColumnTypes()[Entity::ID_ENTRY])
            ->execute()
            ->fetch(\PDO::FETCH_ASSOC);

        if(empty($result)) throw new EntityNotFoundException("entity not found", 404);

        return $this->createFromArray($result);
    }

    /**
     * @param PageInfo $page
     * @param string $order
     * @return \Traversable
     * @throws DBALException
     */
    public function findAll(PageInfo $page, string $order = self::ASC_ORDER): \Traversable
    {
        $dir = $order === self::ASC_ORDER ? '>' : '<';
        $q = 'SELECT * FROM ' . static::getTable() . " WHERE id $dir ? ORDER BY id $order LIMIT ?";
        $result = $this->getConnection()->executeQuery(
            $q,
            [$page->getToken(), $page->getSize()],
            [static::getColumnTypes()[Entity::ID_ENTRY], \PDO::PARAM_INT]
        );
        return new EntityCursor($this, $result);
    }

    public function createFromArray(array $data)
    {
        /** @var Entity $class */
        $class = $this->getEntityClass();
        return $class::createFromArray($data);
    }

    public static abstract function getTable(): string;

    public static abstract function addTableSchema(Schema $schema);

    public static abstract function getEntityClass(): string;

    public static abstract function getColumnTypes(): array;

    public function getConnection(): Connection
    {
        return $this->getManager()->getConnection();
    }

    public function getManager(): EntityManager
    {
        return $this->manager;
    }
}