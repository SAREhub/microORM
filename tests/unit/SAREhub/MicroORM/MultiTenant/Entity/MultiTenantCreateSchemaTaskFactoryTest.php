<?php

namespace SAREhub\MicroORM\MultiTenant\Entity;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use SAREhub\MicroORM\Entity\CreateSchemaTask;

class MultiTenantCreateSchemaTaskFactoryTest extends TestCase
{

    public function testCreate()
    {
        $entityManagerFactory = \Mockery::mock(MultiTenantEntityManagerFactory::class);
        $taskFactory = new MultiTenantCreateSchemaTaskFactory($entityManagerFactory);

        $tenantId = "1";
        $em = \Mockery::mock(EntityManager::class);
        $entityManagerFactory->expects("create")->with($tenantId)->andReturn($em);

        $this->assertInstanceOf(CreateSchemaTask::class, $taskFactory->create($tenantId));
    }
}
