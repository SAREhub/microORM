<?php


namespace SAREhub\MicroORM\MultiTenant\Connection;

use SAREhub\MicroORM\Connection\ConnectionOptions;

class StaticMultiTenantConnectionOptionsProvider implements MultiTenantConnectionOptionsProvider
{
    /**
     * @var ConnectionOptions
     */
    private $options;

    public function __construct(ConnectionOptions $options)
    {
        $this->options = $options;
    }


    public function get(string $tenantId): ConnectionOptions
    {
        return $this->options;
    }
}
