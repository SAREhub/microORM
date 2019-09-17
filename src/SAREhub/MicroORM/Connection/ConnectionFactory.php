<?php


namespace SAREhub\MicroORM\Connection;

use Doctrine\DBAL\Connection;
use SAREhub\MicroORM\DatabaseException;

interface ConnectionFactory
{
    /**
     * Returns connection with selected database
     * @param ConnectionOptions $options
     * @param string $databaseName
     * @throws DatabaseException
     * @return Connection
     */
    public function create(ConnectionOptions $options, string $databaseName = ""): Connection;
}
