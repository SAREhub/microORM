<?php

namespace SAREhub\MicroORM\Connection;

use Doctrine\DBAL\Connection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class ConnectionsPingCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testInvoke()
    {
        $command = new ConnectionsPingCommand();
        $connection = \Mockery::mock(Connection::class);
        $command->addConnection($connection);

        $connection->expects("ping");

        $command();
    }
}
