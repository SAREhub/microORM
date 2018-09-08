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


use SAREhub\Commons\Misc\EnvironmentHelper;
use SAREhub\Commons\Misc\InvokableProvider;
use SAREhub\Commons\Secret\SecretValueNotFoundException;
use SAREhub\Commons\Secret\SecretValueProvider;

class EnvConnectionOptionsProvider extends InvokableProvider
{
    const ENV_HOST = "HOST";
    const ENV_PORT = "PORT";

    const ENV_USER = "USER";
    const ENV_PASSWORD_SECRET = "PASSWORD_SECRET";

    const ENV_SCHEMA = [
        self::ENV_HOST => ConnectionOptions::DEFAULT_HOST,
        self::ENV_PORT => ConnectionOptions::DEFAULT_PORT,
        self::ENV_USER => ConnectionOptions::DEFAULT_USER,
        self::ENV_PASSWORD_SECRET => ""
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
        $env = EnvironmentHelper::getVars(self::ENV_SCHEMA, $this->envPrefix);
        return ConnectionOptions::newInstance()
            ->setHost($env[self::ENV_HOST])
            ->setPort($env[self::ENV_PORT])
            ->setUser($env[self::ENV_USER])
            ->setPassword($this->secretValueProvider->get($env[self::ENV_PASSWORD_SECRET]));
    }
}