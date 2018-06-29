<?php


namespace SAREhub\MicroORM\Connection;


use Doctrine\DBAL\Connection;

class CachedConnectionFactory implements ConnectionFactory
{
    /**
     * @var ConnectionFactory
     */
    private $factory;

    /**
     * @var Connection[]
     */
    private $toDatabaseCache = [];

    private $toHostCache = null;

    public function __construct(ConnectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createToDatabase(string $databaseName): Connection
    {
        if (!isset($this->toDatabaseCache[$databaseName])) {
            $this->toDatabaseCache[$databaseName] = $this->factory->createToDatabase($databaseName);
        }
        return $this->toDatabaseCache[$databaseName];
    }

    public function createToHost(): Connection
    {
        if ($this->toHostCache === null) {
            $this->toHostCache = $this->factory->createToHost();
        }
        return $this->toHostCache;
    }
}