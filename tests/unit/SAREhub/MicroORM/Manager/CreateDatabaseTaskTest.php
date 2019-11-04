<?php

namespace SAREhub\MicroORM\Manager;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class CreateDatabaseTaskTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRun()
    {
        $databaseManager = \Mockery::mock(DatabaseManager::class);
        $databaseName = "test";
        $options = CreateDatabaseOptions::newInstance();
        $task = new CreateDatabaseTask($databaseManager, $databaseName, $options);

        $databaseManager->expects("create")->with($databaseName, $options);

        $task->run();
    }
}
