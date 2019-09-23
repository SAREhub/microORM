<?php


namespace SAREhub\MicroORM\MultiTenant\Entity;


use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use SAREhub\MicroORM\Entity\EntityManagerFactory;
use SAREhub\MicroORM\MultiTenant\Connection\MultiTenantConnectionFactory;

class MultiTenantEntityManagerFactory
{
    /**
     * @var MultiTenantConnectionFactory
     */
    private $tenantConnectionFactory;

    /**
     * @var EntityManagerFactory
     */
    private $entityManagerFactory;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(
        MultiTenantConnectionFactory $tenantConnectionFactory, EntityManagerFactory $entityManagerFactory, Configuration $configuration
    )
    {
        $this->tenantConnectionFactory = $tenantConnectionFactory;
        $this->entityManagerFactory = $entityManagerFactory;
        $this->configuration = $configuration;
    }

    public function create(string $tenantId): EntityManager
    {
        $connection = $this->tenantConnectionFactory->create($tenantId);
        return $this->entityManagerFactory->create($connection, $this->configuration);
    }
}
