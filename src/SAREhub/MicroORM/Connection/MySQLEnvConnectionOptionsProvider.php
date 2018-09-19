<?php
/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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
        $env[self::ENV_PASSWORD_SECRET] = $this->secretValueProvider->get($env[self::ENV_PASSWORD_SECRET]);
        return new ConnectionOptions(array_change_key_case($env, CASE_LOWER));
    }

    private function createPlatformFromName(string $name): AbstractPlatform
    {
        $platformClass = "\\Doctrine\\DBAL\\Platforms\\${name}Platform";
        return new $platformClass();
    }
}