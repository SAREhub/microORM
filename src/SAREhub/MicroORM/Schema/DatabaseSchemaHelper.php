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

namespace SAREhub\MicroORM\Schema;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\Schema;
use SAREhub\MicroORM\DatabaseException;

class DatabaseSchemaHelper
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Schema $schema
     */
    public function create(Schema $schema)
    {
        $queries = $schema->toSql($this->getDatabasePlatform());
        $this->executeQueries($queries);
    }

    /**
     * @param Schema $schema
     */
    public function drop(Schema $schema)
    {
        $queries = $schema->toDropSql($this->getDatabasePlatform());
        $this->executeQueries($queries);
    }

    /**
     * @param array $queries
     */
    private function executeQueries(array $queries)
    {
        try {
            foreach ($queries as $query) {
                $this->connection->exec($query);
            }
        } catch (DBALException $e) {
            throw DatabaseException::createFromDBAL($e, "database schema update error");
        }
    }

    private function getDatabasePlatform(): AbstractPlatform
    {
        try {
            return $this->connection->getDatabasePlatform();
        } catch (DBALException $e) {
            throw DatabaseException::createFromDBAL($e, "database platform get error");
        }
    }
}