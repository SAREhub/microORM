<?php


namespace SAREhub\MicroORM\Connection;


use SAREhub\Commons\Misc\InvokableProvider;

class ConnectionProvider extends InvokableProvider
{
    /**
     * @var ConnectionFactory
     */
    private $factory;

    /**
     * @var ConnectionOptions
     */
    private $options;

    /**
     * @var string
     */
    private $dbName;

    public function __construct(ConnectionFactory $factory, ConnectionOptions $options, string $dbName = "")
    {
        $this->factory = $factory;
        $this->options = $options;
        $this->dbName = $dbName;
    }

    public function get()
    {
        return $this->factory->create($this->options, $this->dbName);
    }
}
