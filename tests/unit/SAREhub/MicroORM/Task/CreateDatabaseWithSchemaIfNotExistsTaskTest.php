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

namespace SAREhub\MicroORM\Task;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SAREhub\MicroORM\Manager\DatabaseManager;
use SAREhub\MicroORM\Schema\CreateSchemaTask;

class CreateDatabaseWithSchemaIfNotExistsTaskTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var DatabaseManager | MockInterface
     */
    private $databaseManager;

    /**
     * @var CreateSchemaTask | MockInterface
     */
    private $initSchemaTask;

    /**
     * @var CreateDatabaseWithSchemaIfNotExistsTask
     */
    private $task;

    protected function setUp()
    {
        $this->databaseManager = \Mockery::mock(DatabaseManager::class);
        $this->initSchemaTask = \Mockery::mock(CreateSchemaTask::class);
        $this->task = new CreateDatabaseWithSchemaIfNotExistsTask("test_name", $this->databaseManager, $this->initSchemaTask);
    }

    public function testRunWhenExists()
    {
        $this->databaseManager->expects("exists")->with("test_name")->andReturn(true);
        $this->databaseManager->expects("create")->never();
        $this->initSchemaTask->expects("run")->never();
        $this->task->run();
    }

    public function testRunWhenNotExistsThen()
    {
        $this->databaseManager->expects("exists")->with("test_name")->andReturn(false);
        $this->databaseManager->expects("create")->with("test_name");
        $this->initSchemaTask->expects("run")->once();
        $this->task->run();
    }
}
