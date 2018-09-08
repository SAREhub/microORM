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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class BasicDatabaseManager implements DatabaseManager
{
    private const CREATE_DATABASE_SQL_FORMAT = "CREATE DATABASE %s CHARACTER SET %s COLLATE %s";

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $name
     * @param null|CreateDatabaseOptions $options
     * @throws DBALException
     */
    public function create(string $name, ?CreateDatabaseOptions $options = null): void
    {
        $options = $options ?? new CreateDatabaseOptions();
        $sql = sprintf(self::CREATE_DATABASE_SQL_FORMAT, $name, $options->getCharacterSet(), $options->getCollate());
        $this->getConnection()->exec($sql);
    }

    /**
     * @param string $name
     * @throws DBALException
     */
    public function drop(string $name): void
    {
        $this->getConnection()->exec("DROP DATABASE $name");
    }

    public function exists(string $name): bool
    {
        return in_array($name, $this->getList());
    }

    public function getList(): array
    {
        $list = [];
        foreach ($this->getConnection()->getSchemaManager()->listDatabases() as $name) {
            $list[] = (string)$name;
        }
        return $list;
    }

    private function getConnection(): Connection
    {
        return $this->connection;
    }
}