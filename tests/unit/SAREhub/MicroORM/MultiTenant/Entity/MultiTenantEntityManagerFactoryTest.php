<?php

namespace SAREhub\MicroORM\MultiTenant\Entity;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use SAREhub\MicroORM\Entity\EntityManagerFactory;
use SAREhub\MicroORM\MultiTenant\Connection\MultiTenantConnectionFactory;

class MultiTenantEntityManagerFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCreate()
    {
        $tenantConnectionFactory = \Mockery::mock(MultiTenantConnectionFactory::class);
        $entityManagerFactory = \Mockery::mock(EntityManagerFactory::class);
        $configuration = new Configuration();
        $tenantEntityManagerFactory = new MultiTenantEntityManagerFactory($tenantConnectionFactory, $entityManagerFactory, $configuration);

        $tenantId = "1";
        $connection = \Mockery::mock(Connection::class);
        $tenantConnectionFactory->expects("create")->with($tenantId)->andReturn($connection);
        $entityManager = \Mockery::mock(EntityManager::class);
        $entityManagerFactory->expects("create")->with($connection, $configuration)->andReturn($entityManager);

        $this->assertSame($entityManager, $tenantEntityManagerFactory->create($tenantId));

    }
}
