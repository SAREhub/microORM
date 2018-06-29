<?php


namespace SAREhub\MicroORM\Manager;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use SAREhub\MicroORM\Connection\PrefixedConnectionFactory;
use SAREhub\MicroORM\Schema\DatabaseSchema;

class DatabaseManager
{
    /**
     * @var PrefixedConnectionFactory
     */
    private $connectionFactory;

    public function __construct(PrefixedConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * @param DatabaseSchema $schema
     * @throws DBALException
     */
    public function createDatabase(DatabaseSchema $schema): void {
        $schema = clone $schema;
        $schema->setName($this->getPrefixed($schema->getName()));
        $this->getGlobalConnection()->exec($schema->toSql($this->getGlobalConnection()->getDatabasePlatform()));
    }

    /**
     * @param string $name
     * @throws DBALException
     */
    public function dropDatabase(string $name): void
    {
        $name = $this->getPrefixed($name);
        $this->getGlobalConnection()->exec("DROP DATABASE $name");
    }

    /**
     * @param string $name
     * @return bool
     * @throws DBALException
     */
    public function hasDatabase(string $name): bool
    {
        return in_array($name, $this->getDatabaseList());
    }

    /**
     * @return array
     * @throws DBALException
     */
    public function getDatabaseList(): array
    {
        $list = $this->getGlobalConnection()->getSchemaManager()->listDatabases();
        $returnList = [];
        foreach ($list as $name) {
            if ($this->connectionFactory->hasPrefix($name)) {
                $returnList[] = $this->connectionFactory->stripPrefix($name);
            }
        }
        return $returnList;
    }

    /**
     * @param string $name
     * @param Schema $schema
     * @throws DBALException
     */
    public function createSchema(string $name, Schema $schema)
    {
        $conn = $this->getDatabaseConnection($name);
        $queries = $schema->toSql($conn->getDatabasePlatform());
        foreach ($queries as $query) {
            $conn->exec($query);
        }
    }

    /**
     * @param string $name
     * @param Schema $schema
     * @throws DBALException
     */
    public function dropSchema(string $name, Schema $schema)
    {
        $conn = $this->getDatabaseConnection($name);
        $queries = $schema->toDropSql($conn->getDatabasePlatform());
        foreach ($queries as $query) {
            $conn->exec($query);
        }
    }

    private function getPrefixed(string $name): string
    {
        return $this->connectionFactory->getPrefixed($name);
    }

    /**
     * @return Connection
     * @throws DBALException
     */
    private function getGlobalConnection(): Connection
    {
        return $this->connectionFactory->createToHost();
    }

    /**
     * @param string $name
     * @return Connection
     * @throws DBALException
     */
    private function getDatabaseConnection(string $name): Connection
    {
        return $this->connectionFactory->createToDatabase($name);
    }
}