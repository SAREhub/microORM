<?php

namespace SAREhub\MicroORM\Connection;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

interface ConnectionFactory
{
    /**
     * Returns connection with selected database
     * @param string $databaseName
     * @throws DBALException
     * @return Connection
     */
    public function createToDatabase(string $databaseName): Connection;

    /**
     * Returns connection without selected database(can be used to send command without database context)
     * @throws DBALException
     * @return Connection
     */
    public function createToHost(): Connection;
}