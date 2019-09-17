<?php

namespace SAREhub\MicroORM\MultiTenant\Connection;


use Doctrine\DBAL\Connection;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use SAREhub\MicroORM\Connection\ConnectionFactory;
use SAREhub\MicroORM\Connection\ConnectionOptions;

class MultiTenantConnectionFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCreate()
    {
        $options = new ConnectionOptions([]);
        $optionsProvider = new StaticMultiTenantConnectionOptionsProvider($options);

        $connectionFactory = Mockery::mock(ConnectionFactory::class);
        $connection = Mockery::mock(Connection::class);

        $factory = new MultiTenantConnectionFactory($optionsProvider, $connectionFactory);

        $tenantId = "1";
        $connectionFactory->expects("create")->with($options, $tenantId)->andReturn($connection);

        $this->assertSame($connection, $factory->create($tenantId));
    }
}
