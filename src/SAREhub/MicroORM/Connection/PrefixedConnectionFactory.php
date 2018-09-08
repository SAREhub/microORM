<?php


namespace SAREhub\MicroORM\Connection;


use Doctrine\DBAL\Connection;

class PrefixedConnectionFactory implements ConnectionFactory
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var ConnectionFactory
     */
    private $factory;

    public function __construct(string $prefix, ConnectionFactory $factory)
    {
        $this->prefix = $prefix;
        $this->factory = $factory;
    }

    public function create(ConnectionOptions $options, string $databaseName = ""): Connection
    {
        $databaseName = empty($databaseName) ? "" : $this->prefix . $databaseName;
        return $this->factory->create($options, $databaseName);
    }
}