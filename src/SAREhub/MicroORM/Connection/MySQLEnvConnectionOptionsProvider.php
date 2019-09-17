<?php


namespace SAREhub\MicroORM\Connection;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use SAREhub\Commons\Misc\EnvironmentHelper;
use SAREhub\Commons\Misc\InvokableProvider;
use SAREhub\Commons\Secret\SecretValueNotFoundException;
use SAREhub\Commons\Secret\SecretValueProvider;

class MySQLEnvConnectionOptionsProvider extends InvokableProvider
{
    const ENV_HOST = "HOST";
    const ENV_PORT = "PORT";

    const ENV_USER = "USER";
    const ENV_PASSWORD_SECRET = "PASSWORD_SECRET";

    const ENV_DRIVER = "DRIVER";
    const ENV_PLATFORM = "PLATFORM";

    const ENV_PARAMS_SCHEMA = [
        self::ENV_HOST => "localhost",
        self::ENV_PORT => 3306,
        self::ENV_USER => "root",
        self::ENV_PASSWORD_SECRET => "",
        self::ENV_DRIVER => "pdo_mysql",
        self::ENV_PLATFORM => "MySQL57"
    ];

    const DEFAULT_ENV_PREFIX = "DATABASE_";

    /**
     * @var SecretValueProvider
     */
    private $secretValueProvider;

    private $envPrefix;

    public function __construct(SecretValueProvider $secretValueProvider, string $envPrefix = self::DEFAULT_ENV_PREFIX)
    {
        $this->secretValueProvider = $secretValueProvider;
        $this->envPrefix = $envPrefix;
    }

    /**
     * @return ConnectionOptions
     * @throws SecretValueNotFoundException
     */
    public function get()
    {
        $env = EnvironmentHelper::getVars(self::ENV_PARAMS_SCHEMA, $this->envPrefix);
        $env[self::ENV_PLATFORM] = $this->createPlatformFromName($env[self::ENV_PLATFORM]);
        $this->replacePasswordSecretWithValue($env);
        return new ConnectionOptions(array_change_key_case($env, CASE_LOWER));
    }

    /**
     * @param array $env
     * @throws SecretValueNotFoundException
     */
    private function replacePasswordSecretWithValue(array &$env): void
    {
        $password = $this->secretValueProvider->get($env[self::ENV_PASSWORD_SECRET]);
        unset($env[self::ENV_PASSWORD_SECRET]);
        $env["password"] = $password;
    }

    private function createPlatformFromName(string $name): AbstractPlatform
    {
        $platformClass = "\\Doctrine\\DBAL\\Platforms\\${name}Platform";
        return new $platformClass();
    }
}
