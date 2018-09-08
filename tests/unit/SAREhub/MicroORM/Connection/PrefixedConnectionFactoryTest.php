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

class PrefixedConnectionFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var ConnectionFactory | MockInterface
     */
    private $factory;

    /**
     * @var PrefixedConnectionFactory
     */
    private $prefixedFactory;

    protected function setUp()
    {
        $this->prefix = "test_prefix_";
        $this->factory = \Mockery::mock(ConnectionFactory::class);
        $this->prefixedFactory = new PrefixedConnectionFactory($this->prefix, $this->factory);
    }

    /**
     * @throws DBALException
     */
    public function testCreateWhenNotEmptyDatabaseName()
    {
        $options = ConnectionOptions::newInstance();
        $name = "test_name";
        $expected = \Mockery::mock(Connection::class);
        $this->factory->expects("create")->with($options, $this->prefix . $name)->andReturn($expected);

        $current = $this->prefixedFactory->create($options, $name);

        $this->assertSame($expected, $current);
    }

    /**
     * @throws DBALException
     */
    public function testCreateWhenEmptyDatabaseName()
    {
        $options = ConnectionOptions::newInstance();
        $expected = \Mockery::mock(Connection::class);
        $this->factory->expects("create")->with($options, "")->andReturn($expected);

        $current = $this->prefixedFactory->create($options, "");

        $this->assertSame($expected, $current);
    }
}
