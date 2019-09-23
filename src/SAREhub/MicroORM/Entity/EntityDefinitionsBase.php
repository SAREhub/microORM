<?php


namespace SAREhub\MicroORM\Entity;


use Doctrine\ORM\Configuration;
use ReflectionClass;
use SAREhub\MicroORM\Entity\Cache\CacheConfiguration;
use SAREhub\MicroORM\Entity\Cache\EnvCacheConfigurationProvider;
use function DI\autowire;
use function DI\factory;

abstract class EntityDefinitionsBase
{
    public static function get(): array
    {
        return [
            ConfigurationProvider::class => autowire()->constructorParameter("entitiesPaths", static::entitiesPathsDef()),
            Configuration::class => factory(ConfigurationProvider::class),
            CacheConfiguration::class => factory(EnvCacheConfigurationProvider::class),
            ProxyConfiguration::class => autowire()->constructorParameter("namespace", static::entityNamespaceDef()),
        ];
    }

    protected static abstract function entitiesPathsDef();

    protected static abstract function entityNamespaceDef();

    protected static function extractNamespaceFromClass(string $className)
    {
        $class = new ReflectionClass($className);
        return $class->getNamespaceName();
    }
}
