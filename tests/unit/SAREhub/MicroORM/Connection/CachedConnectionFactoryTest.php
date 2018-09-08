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
use Doctrine\DBAL\DBALException;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CachedConnectionFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var MockInterface | ConnectionFactory
     */
    private $factory;

    /**
     * @var CachedConnectionFactory
     */
    private $cachedFactory;

    /**
     * @var ConnectionOptions
     */
    private $options;

    protected function setUp()
    {
        $this->factory = \Mockery::mock(ConnectionFactory::class);
        $this->cachedFactory = new CachedConnectionFactory($this->factory);
        $this->options = ConnectionOptions::newInstance();
    }

    /**
     * @throws DBALException
     */
    public function testCreateWhenSameNameUsedNextTime()
    {
        $expected = $this->createConnection();
        $this->factory->expects("create")->with($this->options, "test_name")->once()->andReturn($expected);
        $this->cachedFactory->create($this->options, "test_name");

        $this->assertSame($expected, $this->cachedFactory->create($this->options, "test_name"));
    }

    /**
     * @return MockInterface | Connection
     */
    private function createConnection(): Connection
    {
        return \Mockery::mock(Connection::class);
    }
}