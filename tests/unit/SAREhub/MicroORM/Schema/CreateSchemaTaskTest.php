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

use Doctrine\DBAL\Schema\Schema;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use SAREhub\MicroORM\Schema\CreateSchemaTask;
use SAREhub\MicroORM\Schema\DatabaseSchemaHelper;

class CreateSchemaTaskTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    public function testRun()
    {
        $helper = \Mockery::mock(DatabaseSchemaHelper::class);
        $schema = new Schema();
        $task = new CreateSchemaTask($helper, $schema);

        $helper->expects("create")->with($schema);
        $task->run();
    }
}
