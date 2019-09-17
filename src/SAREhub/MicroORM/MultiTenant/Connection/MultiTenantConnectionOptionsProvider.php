<?php


namespace SAREhub\MicroORM\MultiTenant\Connection;


use SAREhub\MicroORM\Connection\ConnectionOptions;

interface MultiTenantConnectionOptionsProvider
{
    public function get(string $tenantId): ConnectionOptions;
}
