<?php


namespace SAREhub\MicroORM\Connection;


use Doctrine\DBAL\Configuration;


class ConnectionOptions
{
    /**
     * @var  array
     */
    private $params;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(array $params, ?Configuration $configuration = null)
    {
        $this->params = $params;
        $this->configuration = $configuration ?? new Configuration();
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }
}
