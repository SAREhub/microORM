<?php


namespace SAREhub\MicroORM\Connection;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class BasicConnectionFactory implements ConnectionFactory
{
    /**
     * @var array
     */
    private $baseParams;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(array $baseParams, Configuration $configuration)
    {
        $this->baseParams = $baseParams;
        $this->configuration = $configuration;
    }

    public function createToDatabase(string $databaseName): Connection
    {
        return DriverManager::getConnection($this->createDatabaseParams($databaseName), $this->configuration);
    }

    private function createDatabaseParams(string $databaseName): array
    {
        $params = $this->baseParams;
        if (!empty($databaseName)) {
            $params["dbname"] = $databaseName;
        }
        return $params;
    }

    public function createToHost(): Connection
    {
        return DriverManager::getConnection($this->baseParams, $this->configuration);
    }
}