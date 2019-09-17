<?php

namespace SAREhub\MicroORM\Entity;

use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\ORM\Configuration;
use SAREhub\Commons\Misc\InvokableProvider;
use SAREhub\MicroORM\Entity\Cache\CacheConfiguration;

class ConfigurationProvider extends InvokableProvider
{

    /**
     * @var CacheConfiguration
     */
    private $cacheConfig;

    /**
     * @var ProxyConfiguration
     */
    private $proxyConfig;

    /**
     * @var array
     */
    private $entitiesPaths;

    public function __construct(CacheConfiguration $cacheConfig, ProxyConfiguration $proxyConfig, array $entitiesPaths)
    {
        $this->cacheConfig = $cacheConfig;
        $this->proxyConfig = $proxyConfig;
        $this->entitiesPaths = $entitiesPaths;
    }

    public function get()
    {
        $config = new Configuration();
        $this->setupCache($config);
        $this->setupProxy($config);
        $this->setupMetadataDriver($config);
        return $config;
    }

    private function setupCache(Configuration $config): void
    {
        $config->setMetadataCacheImpl($this->cacheConfig->getMetadataCache());
        $config->setQueryCacheImpl($this->cacheConfig->getQueryCache());
    }

    private function setupProxy(Configuration $config): void
    {
        $config->setProxyDir($this->proxyConfig->getDir());
        $config->setProxyNamespace($this->proxyConfig->getNamespace());
        $config->setAutoGenerateProxyClasses($this->proxyConfig->isGenerateOnFly() ?
            AbstractProxyFactory::AUTOGENERATE_EVAL :
            AbstractProxyFactory::AUTOGENERATE_NEVER
        );
    }

    private function setupMetadataDriver(Configuration $config): void
    {
        $driver = $config->newDefaultAnnotationDriver($this->entitiesPaths);
        $config->setMetadataDriverImpl($driver);
    }
}
