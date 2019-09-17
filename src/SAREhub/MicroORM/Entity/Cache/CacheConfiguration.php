<?php


namespace SAREhub\MicroORM\Entity\Cache;


use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\VoidCache;

class CacheConfiguration
{
    /**
     * @var Cache
     */
    private $metadataCache;

    /**
     * @var Cache
     */
    private $queryCache;

    public function __construct(?Cache $metadataCache = null, ?Cache $queryCache = null)
    {
        $this->metadataCache = $metadataCache ?? new VoidCache();
        $this->queryCache = $queryCache ?? new VoidCache();
    }

    public function getMetadataCache(): Cache
    {
        return $this->metadataCache;
    }

    public function getQueryCache(): Cache
    {
        return $this->queryCache;
    }
}
