<?php


namespace SAREhub\MicroORM\Entity;


use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use SAREhub\MicroORM\DatabaseException;

class EntityManagerFactory
{
    public function create(Connection $connection, Configuration $configuration): EntityManager
    {
        try {
            return EntityManager::create($connection, $configuration);
        } catch (ORMException $e) {
            DatabaseException::createFromOrm($e, "Create EntityManager error");
        }
    }
}
