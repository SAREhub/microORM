<?php


namespace SAREhub\MicroORM\Manager;


use SAREhub\Commons\Task\Task;

class CreateDatabaseTask implements Task
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @var string
     */
    private $databaseName;

    /**
     * @var CreateDatabaseOptions
     */
    private $options;

    public function __construct(DatabaseManager $databaseManager, string $databaseName, CreateDatabaseOptions $options)
    {
        $this->databaseManager = $databaseManager;
        $this->databaseName = $databaseName;
        $this->options = $options;
    }

    public function run()
    {
        $this->databaseManager->create($this->databaseName, $this->options);
    }
}
