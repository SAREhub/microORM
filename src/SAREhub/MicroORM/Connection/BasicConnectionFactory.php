<?php

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
