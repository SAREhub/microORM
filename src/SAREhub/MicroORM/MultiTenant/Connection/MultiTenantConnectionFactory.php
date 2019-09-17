<?php


namespace SAREhub\MicroORM\MultiTenant\Connection;


use Doctrine\DBAL\Connection;
use SAREhub\MicroORM\Connection\ConnectionFactory;

class MultiTenantConnectionFactory
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var MultiTenantConnectionOptionsProvider
     */
    private $optionsProvider;

    public function __construct(MultiTenantConnectionOptionsProvider $optionsProvider, ConnectionFactory $factory)
    {
        $this->connectionFactory = $factory;
        $this->optionsProvider = $optionsProvider;
    }

    public function create(string $tenantId): Connection
    {
        $options = $this->optionsProvider->get($tenantId);
        return $this->connectionFactory->create($options, $tenantId);
    }
}
