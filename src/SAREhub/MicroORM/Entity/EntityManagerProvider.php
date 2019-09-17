<?php

namespace SAREhub\MicroORM\Entity;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use SAREhub\Commons\Misc\InvokableProvider;

class EntityManagerProvider extends InvokableProvider
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Connection $connection, Configuration $configuration)
    {
        $this->connection = $connection;
        $this->configuration = $configuration;
    }

    public function get()
    {
        return EntityManager::create($this->connection, $this->configuration);
    }
}
