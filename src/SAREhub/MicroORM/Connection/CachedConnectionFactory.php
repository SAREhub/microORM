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


use Doctrine\DBAL\Connection;

class CachedConnectionFactory implements ConnectionFactory
{
    /**
     * @var ConnectionFactory
     */
    private $factory;

    /**
     * @var Connection[]
     */
    private $cache = [];

    public function __construct(ConnectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(ConnectionOptions $options, string $databaseName = ""): Connection
    {
        $cacheKey = $this->createCacheKey($options, $databaseName);
        if (!isset($this->cache[$cacheKey])) {
            $this->cache[$cacheKey] = $this->factory->create($options, $databaseName);
        }
        return $this->cache[$cacheKey];
    }

    private function createCacheKey(ConnectionOptions $options, string $databaseName): string
    {
        return implode(":", $options->getParams()) . ":$databaseName";
    }
}