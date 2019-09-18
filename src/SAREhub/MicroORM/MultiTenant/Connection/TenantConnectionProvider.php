<?php


namespace SAREhub\MicroORM\MultiTenant\Connection;


use SAREhub\Commons\Misc\InvokableProvider;

class TenantConnectionProvider extends InvokableProvider
{
    /**
     * @var MultiTenantConnectionFactory
     */
    private $factory;

    /**
     * @var string
     */
    private $tenantId;

    public function __construct(MultiTenantConnectionFactory $factory, string $tenantId)
    {
        $this->factory = $factory;
        $this->tenantId = $tenantId;
    }

    public function get()
    {
        return $this->factory->create($this->tenantId);
    }
}

