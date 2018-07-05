<?php

namespace SAREhub\MicroORM\Connection;

use Doctrine\DBAL\Connection;

class ConnectionsPingCommand
{
    /**
     * @var Connection[]
     */
    private $connections = [];

    public function addConnection(Connection $connection)
    {
        $this->connections[] = $connection;
    }

    public function __invoke()
    {
        foreach ($this->connections as $connection) {
            $connection->ping();
        }
    }

}