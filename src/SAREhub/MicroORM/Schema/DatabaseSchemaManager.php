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
use Doctrine\DBAL\Schema\Schema;

class DatabaseSchemaManager
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     * @param Schema $schema
     * @throws DBALException
     */
    public function createSchema(Connection $connection, Schema $schema)
    {
        $queries = $schema->toSql($connection->getDatabasePlatform());
        foreach ($queries as $query) {
            $connection->exec($query);
        }
    }

    /**
     * @param Connection $connection
     * @param Schema $schema
     * @throws DBALException
     */
    public function dropSchema(Connection $connection, Schema $schema)
    {
        $queries = $schema->toDropSql($connection->getDatabasePlatform());
        foreach ($queries as $query) {
            $connection->exec($query);
        }
    }
}