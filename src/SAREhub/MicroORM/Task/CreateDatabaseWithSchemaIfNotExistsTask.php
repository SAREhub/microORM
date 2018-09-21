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

use SAREhub\Commons\Task\Task;
use SAREhub\MicroORM\Manager\DatabaseManager;

class CreateDatabaseWithSchemaIfNotExistsTask implements Task
{

    /**
     * @var string
     */
    private $databaseName;

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @var Task
     */
    private $initSchemaTask;

    public function __construct(string $databaseName, DatabaseManager $databaseManager, Task $createSchemaTask)
    {
        $this->databaseName = $databaseName;
        $this->databaseManager = $databaseManager;
        $this->initSchemaTask = $createSchemaTask;
    }

    public function run()
    {
        if (!$this->databaseManager->exists($this->databaseName)) {
            $this->databaseManager->create($this->databaseName);
            $this->initSchemaTask->run();
        }
    }
}