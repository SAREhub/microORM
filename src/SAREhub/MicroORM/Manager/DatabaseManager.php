<?php


namespace SAREhub\MicroORM\Manager;


use SAREhub\MicroORM\DatabaseException;

interface DatabaseManager
{

    /**
     * @param string $name
     * @param null|CreateDatabaseOptions $options
     * @throws DatabaseException
     */
    public function create(string $name, ?CreateDatabaseOptions $options = null): void;

    /**
     * @param string $name
     * @throws DatabaseException
     */
    public function drop(string $name);

    /**
     * @param string $name
     * @return bool
     */
    public function exists(string $name): bool;

    /**
     * @return array
     */
    public function getList(): array;
}
