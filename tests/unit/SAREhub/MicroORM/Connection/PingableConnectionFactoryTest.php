<?php

namespace SAREhub\MicroORM\Connection;

use Doctrine\DBAL\Connection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class PingableConnectionFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var ConnectionFactory | MockInterface
     */
    private $decoratedFactory;

    /**
     * @var ConnectionsPingCommand | MockInterface
     */
    private $pingCommand;

    /**
     * @var PingableConnectionFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->decoratedFactory = \Mockery::mock(ConnectionFactory::class);
        $this->pingCommand = \Mockery::mock(ConnectionsPingCommand::class);
        $this->factory = new PingableConnectionFactory($this->decoratedFactory, $this->pingCommand);
    }

    public function testCreateToDatabase()
    {
        $name = "test";
        $connection = $this->createConnection();
        $this->decoratedFactory->expects("createToDatabase")->with($name)->andReturn($connection);
        $this->pingCommand->expects("addConnection")->with($connection);
        $this->assertSame($connection, $this->factory->createToDatabase($name));
    }


    public function testCreateToHost()
    {
        $connection = $this->createConnection();
        $this->decoratedFactory->expects("createToHost")->andReturn($connection);
        $this->pingCommand->expects("addConnection")->with($connection);
        $this->assertSame($connection, $this->factory->createToHost());
    }

    /**
     * @return Connection | MockInterface
     */
    private function createConnection()
    {
        return \Mockery::mock(Connection::class);
    }
}
