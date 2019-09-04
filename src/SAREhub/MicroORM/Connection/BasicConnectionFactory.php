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

namespace SAREhub\MicroORM\Connection;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use SAREhub\MicroORM\DatabaseException;

class BasicConnectionFactory implements ConnectionFactory
{
    public function create(ConnectionOptions $options, string $databaseName = ""): Connection
    {
        $params = $this->createParams($options, $databaseName);
        try {
            return DriverManager::getConnection($params, $options->getConfiguration());
        } catch (DBALException $e) {
            throw DatabaseException::createFromDBAL($e, "create connection to: '$databaseName'");
        }
    }

    private function createParams(ConnectionOptions $options, string $databaseName): array
    {
        return empty($databaseName) ? $options->getParams() : $this->createDatabaseParams($options, $databaseName);
    }

    private function createDatabaseParams(ConnectionOptions $options, string $databaseName): array
    {
        $params = $options->getParams();
        $params["dbname"] = $databaseName;
        return $params;
    }
}