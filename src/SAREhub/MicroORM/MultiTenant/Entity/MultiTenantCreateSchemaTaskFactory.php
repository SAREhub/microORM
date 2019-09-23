<?php


namespace SAREhub\MicroORM\MultiTenant\Entity;


use SAREhub\MicroORM\Entity\CreateSchemaTask;

class MultiTenantCreateSchemaTaskFactory
{
    /**
     * @var MultiTenantEntityManagerFactory
     */
    private $entityManagerFactory;

    public function __construct(MultiTenantEntityManagerFactory $entityManagerFactory)
    {
        $this->entityManagerFactory = $entityManagerFactory;
    }

    public function create(string $tenantId): CreateSchemaTask
    {
        $em = $this->entityManagerFactory->create($tenantId);
        return new CreateSchemaTask($em);
    }
}
