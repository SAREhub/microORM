<?php

namespace SAREhub\MicroORM\Entity;

class ProxyConfiguration
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var bool
     */
    private $generateOnFly;

    /**
     * @var string
     */
    private $dir;

    public function __construct(string $namespace, bool $generateOnFly = true, string $dir = "Proxies")
    {
        $this->namespace = $namespace;
        $this->generateOnFly = $generateOnFly;
        $this->dir = $dir;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function isGenerateOnFly(): bool
    {
        return $this->generateOnFly;
    }

    public function getDir(): string
    {
        return $this->dir;
    }
}
