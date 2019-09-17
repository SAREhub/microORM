<?php

namespace SAREhub\MicroORM\Entity\Cache;


use Doctrine\Common\Cache\Cache;
use SAREhub\Commons\Misc\EnvironmentHelper;
use SAREhub\Commons\Misc\InvokableProvider;

class EnvCacheConfigurationProvider extends InvokableProvider
{
    const DEFAULT_METADATA_CACHE_TYPE = "Array";
    const ENV_METADATA_CACHE_TYPE = "DOCTRINE_METADATA_CACHE_TYPE";

    const DEFAULT_QUERY_CACHE_TYPE = "Void";
    const ENV_QUERY_CACHE_TYPE = "DOCTRINE_QUERY_CACHE_TYPE";

    public function get()
    {
        $metadataCache = $this->createCacheFromType($this->getMetadataCacheTypeFromEnv());
        $queryCache = $this->createCacheFromType($this->getQueryCacheTypeFromEnv());
        return new CacheConfiguration($metadataCache, $queryCache);
    }

    private function createCacheFromType(string $type): Cache
    {
        $class = "\\Doctrine\\Common\\Cache\\${type}Cache";
        return new $class;
    }

    private function getMetadataCacheTypeFromEnv(): string
    {
        return EnvironmentHelper::getVar(self::ENV_METADATA_CACHE_TYPE, self::DEFAULT_METADATA_CACHE_TYPE);
    }

    private function getQueryCacheTypeFromEnv(): string
    {
        return EnvironmentHelper::getVar(self::ENV_QUERY_CACHE_TYPE, self::DEFAULT_QUERY_CACHE_TYPE);
    }
}
