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

namespace SAREhub\MicroORM\Manager;

use Doctrine\DBAL\DBALException;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class PrefixedDatabaseManagerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var DatabaseManager | MockInterface
     */
    private $decorated;

    /**
     * @var DatabaseManager
     */
    private $manager;

    protected function setUp()
    {
        $this->decorated = \Mockery::mock(DatabaseManager::class);
        $this->manager = new PrefixedDatabaseManager("test_", $this->decorated);
    }

    /**
     * @throws DBALException
     */
    public function testCreate()
    {
        $options = new CreateDatabaseOptions();
        $this->decorated->expects("create")->with("test_db", $options);

        $this->manager->create("db", $options);
    }

    /**
     * @throws DBALException
     */
    public function testDrop()
    {
        $this->decorated->expects("drop")->with("test_db");

        $this->manager->drop("db");
    }

    public function testExists()
    {
        $this->decorated->expects("exists")->with("test_db")->andReturn(true);

        $this->assertTrue($this->manager->exists("db"));
    }

    public function testGetList()
    {

        $this->decorated->expects("getList")->andReturn([
            "test_db",
            "other"
        ]);

        $this->assertEquals(["db"], $this->manager->getList());
    }
}
