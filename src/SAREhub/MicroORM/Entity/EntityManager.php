<?php

namespace SAREhub\MicroORM\Entity;

use Doctrine\DBAL\Connection;

class EntityManager
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var EntityRepository[]
     */
    private $repositories;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->repositories = [];
    }

    /**
     * @param string $class Repository class
     * @return mixed | EntityRepository
     */
    public function getRepository(string $class)
    {
        if (!isset($this->repositories[$class])) {
            $this->repositories[$class] = $this->createRepository($class);
        }

        return $this->repositories[$class];
    }

    private function createRepository(string $class)
    {
        return new $class($this);
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }
}