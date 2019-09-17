<?php

namespace SAREhub\MicroORM\Connection;

use Doctrine\DBAL\Connection;

class ConnectionPingChecker
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function check(): bool
    {
        return $this->connection->ping();
    }

}
