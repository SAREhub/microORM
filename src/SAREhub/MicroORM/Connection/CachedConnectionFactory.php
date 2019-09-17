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
    private $cache = [];

    public function __construct(ConnectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(ConnectionOptions $options, string $databaseName = ""): Connection
    {
        $cacheKey = $this->createCacheKey($options, $databaseName);
        if (!isset($this->cache[$cacheKey])) {
            $this->cache[$cacheKey] = $this->factory->create($options, $databaseName);
        }
        return $this->cache[$cacheKey];
    }

    private function createCacheKey(ConnectionOptions $options, string $databaseName): string
    {
        return implode(":", $options->getParams()) . ":$databaseName";
    }
}
