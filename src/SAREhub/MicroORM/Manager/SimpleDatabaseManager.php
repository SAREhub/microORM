<?php


namespace SAREhub\MicroORM\Manager;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use SAREhub\MicroORM\Connection\ConnectionFactory;

class SimpleDatabaseManager
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * @param string $name
     * @throws DBALException
     */
    public function createDatabase(string $name): void
    {
        $this->getGlobalConnection()->exec("CREATE DATABASE $name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    /**
     * @param string $name
     * @throws DBALException
     */
    public function dropDatabase(string $name): void
    {
        $this->getGlobalConnection()->exec("DROP DATABASE $name");
    }

    /**
     * @param string $name
     * @return bool
     * @throws DBALException
     */
    public function hasDatabase(string $name): bool
    {
        return in_array($name, $this->getDatabaseList());
    }

    /**
     * @return array
     * @throws DBALException
     */
    public function getDatabaseList(): array
    {
        return $this->getGlobalConnection()->getSchemaManager()->listDatabases();
    }

    /**
     * @param string $name
     * @param Schema $schema
     * @throws DBALException
     */
    public function createSchema(string $name, Schema $schema)
    {
        $conn = $this->getDatabaseConnection($name);
        $queries = $schema->toSql($conn->getDatabasePlatform());
        foreach ($queries as $query) {
            $conn->exec($query);
        }
    }

    /**
     * @param string $name
     * @param Schema $schema
     * @throws DBALException
     */
    public function dropSchema(string $name, Schema $schema)
    {
        $conn = $this->getDatabaseConnection($name);
        $queries = $schema->toDropSql($conn->getDatabasePlatform());
        foreach ($queries as $query) {
            $conn->exec($query);
        }
    }

    /**
     * @return Connection
     * @throws DBALException
     */
    private function getGlobalConnection(): Connection
    {
        return $this->connectionFactory->createToHost();
    }

    /**
     * @param string $name
     * @return Connection
     * @throws DBALException
     */
    private function getDatabaseConnection(string $name): Connection
    {
        return $this->connectionFactory->createToDatabase($name);
    }
}