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


use Doctrine\DBAL\Configuration;

class ConnectionOptions
{
    const DEFAULT_HOST = "localhost";
    /**
     * @var string
     */
    private $host = self::DEFAULT_HOST;

    const DEFAULT_PORT = 3306;
    /**
     * @var int
     */
    private $port = self::DEFAULT_PORT;

    const DEFAULT_USER = "root";
    /**
     * @var string
     */
    private $user = self::DEFAULT_USER;

    /**
     * @var string
     */
    private $password = "";

    const DEFAULT_DRIVER = "pdo_mysql";

    /**
     * @var string
     */
    private $driver = self::DEFAULT_DRIVER;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct()
    {
        $this->configuration = new Configuration();
    }

    public static function newInstance(): self
    {
        return new self();
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): ConnectionOptions
    {
        $this->host = $host;
        return $this;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port): ConnectionOptions
    {
        $this->port = $port;
        return $this;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): ConnectionOptions
    {
        $this->user = $user;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password): ConnectionOptions
    {
        $this->password = $password;
        return $this;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function setDriver(string $driver): ConnectionOptions
    {
        $this->driver = $driver;
        return $this;
    }

    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    public function setConfiguration(Configuration $configuration): ConnectionOptions
    {
        $this->configuration = $configuration;
        return $this;
    }

    public function toArray()
    {
        return [
            "host" => $this->getHost(),
            "port" => $this->getPort(),
            "user" => $this->getUser(),
            "password" => $this->getPassword(),
            "driver" => $this->getDriver(),
        ];
    }
}