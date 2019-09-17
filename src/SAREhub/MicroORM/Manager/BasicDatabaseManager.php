<?php


namespace SAREhub\MicroORM\Manager;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use SAREhub\MicroORM\DatabaseException;

class BasicDatabaseManager implements DatabaseManager
{
    private const CREATE_DATABASE_SQL_FORMAT = "CREATE DATABASE %s %s CHARACTER SET %s COLLATE %s";

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(string $name, ?CreateDatabaseOptions $options = null): void
    {
        try {
            $options = $options ?? new CreateDatabaseOptions();
            $sql = sprintf(self::CREATE_DATABASE_SQL_FORMAT,
                ($options->isIfNotExists()) ? "IF NOT EXISTS" : "",
                $name,
                $options->getCharacterSet(),
                $options->getCollate()
            );
            $this->getConnection()->exec($sql);
        } catch (DBALException $e) {
            throw DatabaseException::createFromDBAL($e, "create '$name' database");
        }
    }

    public function drop(string $name): void
    {
        try {
            $this->getConnection()->exec("DROP DATABASE $name");
        } catch (DBALException $e) {
            throw DatabaseException::createFromDBAL($e, "drop '$name' database");
        }
    }

    public function exists(string $name): bool
    {
        return in_array($name, $this->getList());
    }

    public function getList(): array
    {
        $list = [];
        foreach ($this->getConnection()->getSchemaManager()->listDatabases() as $name) {
            $list[] = (string)$name;
        }
        return $list;
    }

    private function getConnection(): Connection
    {
        return $this->connection;
    }
}
