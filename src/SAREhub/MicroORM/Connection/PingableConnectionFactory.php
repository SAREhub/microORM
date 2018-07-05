<?php

namespace SAREhub\MicroORM\Connection;

use Doctrine\DBAL\Connection;

class PingableConnectionFactory implements ConnectionFactory
{

    /**
     * @var ConnectionFactory
     */
    private $decorated;

    /**
     * @var ConnectionsPingCommand
     */
    private $pingCommand;

    public function __construct(ConnectionFactory $decorated, ConnectionsPingCommand $pingCommand)
    {
        $this->decorated = $decorated;
        $this->pingCommand = $pingCommand;
    }

    public function createToDatabase(string $databaseName): Connection
    {
        $connection = $this->decorated->createToDatabase($databaseName);
        $this->pingCommand->addConnection($connection);
        return $connection;
    }

    public function createToHost(): Connection
    {
        $connection = $this->decorated->createToHost();
        $this->pingCommand->addConnection($connection);
        return $connection;
    }
}