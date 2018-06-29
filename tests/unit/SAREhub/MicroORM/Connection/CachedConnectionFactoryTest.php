<?php

namespace SAREhub\MicroORM\Connection;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CachedConnectionFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var MockInterface | ConnectionFactory
     */
    private $factory;

    /**
     * @var CachedConnectionFactory
     */
    private $cachedFactory;

    protected function setUp()
    {
        $this->factory = \Mockery::mock(ConnectionFactory::class);
        $this->cachedFactory = new CachedConnectionFactory($this->factory);
    }

    /**
     * @throws DBALException
     */
    public function testCreateToDatabaseWhenSameNameUsedNextTime()
    {
        $expected = $this->createConnection();
        $this->factory->expects("createToDatabase")->with("test_name")->once()->andReturn($expected);
        $this->cachedFactory->createToDatabase("test_name");

        $this->assertSame($expected, $this->cachedFactory->createToDatabase("test_name"));
    }

    /**
     * @throws DBALException
     */
    public function testCreateToHostWhenNextTime()
    {
        $expected = $this->createConnection();
        $this->factory->expects("createToHost")->with()->once()->andReturn($expected);
        $this->cachedFactory->createToHost();

        $this->assertSame($expected, $this->cachedFactory->createToHost());
    }

    /**
     * @return MockInterface | Connection
     */
    private function createConnection(): Connection
    {
        return \Mockery::mock(Connection::class);
    }
}