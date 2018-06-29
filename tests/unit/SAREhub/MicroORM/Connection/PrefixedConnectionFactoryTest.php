<?php

namespace SAREhub\MicroORM\Connection;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class PrefixedConnectionFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var ConnectionFactory | MockInterface
     */
    private $connectionFactory;

    /**
     * @var PrefixedConnectionFactory
     */
    private $prefixedFactory;

    protected function setUp()
    {
        $this->prefix = "test_prefix_";
        $this->connectionFactory = \Mockery::mock(ConnectionFactory::class);
        $this->prefixedFactory = new PrefixedConnectionFactory($this->prefix, $this->connectionFactory);
    }

    /**
     * @throws DBALException
     */
    public function testCreateToDatabase()
    {
        $name = "test_name";
        $expected = \Mockery::mock(Connection::class);
        $this->connectionFactory->expects("createToDatabase")->with($this->prefix . $name)->andReturn($expected);

        $current = $this->prefixedFactory->createToDatabase($name);

        $this->assertSame($expected, $current);
    }

    /**
     * @throws DBALException
     */
    public function testCreateToHost()
    {
        $expected = \Mockery::mock(Connection::class);
        $this->connectionFactory->expects("createToHost")->andReturn($expected);

        $current = $this->prefixedFactory->createToHost();

        $this->assertSame($expected, $current);
    }
}
