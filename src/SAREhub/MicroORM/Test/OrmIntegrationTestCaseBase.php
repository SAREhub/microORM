<?php


namespace SAREhub\MicroORM\Test;


use DI\ContainerBuilder;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use SAREhub\Commons\DI\Test\ContainerAwareIntegrationTestCase;
use SAREhub\MicroORM\Connection\BasicConnectionFactory;
use SAREhub\MicroORM\Connection\ConnectionFactory;
use SAREhub\MicroORM\Connection\ConnectionOptions;
use SAREhub\MicroORM\Connection\MySQLEnvConnectionOptionsProvider;
use SAREhub\MicroORM\DatabaseException;
use SAREhub\MicroORM\Entity\CreateSchemaTask;
use SAREhub\MicroORM\Manager\BasicDatabaseManager;
use SAREhub\MicroORM\Manager\DatabaseManager;
use function DI\autowire;
use function DI\factory;
use function DI\get;

abstract class OrmIntegrationTestCaseBase extends ContainerAwareIntegrationTestCase
{
    /**
     * @var EntityManager $em
     */
    protected $em;

    protected function setUp()
    {
        parent::setUp();
        $this->recreateDatabase();
        $this->em = $this->container->get(EntityManager::class);
    }

    protected function tearDown()
    {
        $this->clearDatabase();
    }

    protected abstract function getDatabaseName(): string;

    protected function addDefinitions(ContainerBuilder $builder): void
    {
        parent::addDefinitions($builder);
        $builder->addDefinitions([
            ConnectionFactory::class => get(BasicConnectionFactory::class),
            MySQLEnvConnectionOptionsProvider::class => autowire()->constructorParameter("envPrefix", "MYSQL_"),
            ConnectionOptions::class => factory(MySQLEnvConnectionOptionsProvider::class),
            Connection::class => $this->connectionFactoryDef()
        ]);
    }

    protected function connectionFactoryDef()
    {
        $databaseName = $this->getDatabaseName();
        return factory(function (ConnectionOptions $options, ConnectionFactory $factory) use ($databaseName) {
            return $factory->create($options, $databaseName);
        });
    }

    protected function recreateDatabase(): void
    {
        $this->clearDatabase();
        $this->createDatabase();
        $this->container->get(CreateSchemaTask::class)->run();
    }

    protected function createDatabase(): void
    {
        $globalConnection = $this->createGlobalConnection();
        $databaseManager = $this->createDatabaseManager($globalConnection);
        $databaseName = $this->getDatabaseName();
        $databaseManager->create($databaseName);
        $globalConnection->close();
    }

    protected function clearDatabase(): void
    {
        $globalConnection = $this->createGlobalConnection();
        $databaseManager = $this->createDatabaseManager($globalConnection);
        $databaseName = $this->getDatabaseName();
        if ($databaseManager->exists($databaseName)) {
            $databaseManager->drop($databaseName);
        }
        $globalConnection->close();
    }

    protected function createGlobalConnection(): Connection
    {
        $connectionFactory = $this->container->get(ConnectionFactory::class);
        return $connectionFactory->create($this->container->get(ConnectionOptions::class));
    }

    protected function createDatabaseManager(Connection $connection): DatabaseManager
    {
        return new BasicDatabaseManager($connection);
    }

    protected function saveEntity($entity, bool $clearEntityManager = true): void
    {
        $entities = is_array($entity) ? $entity : [$entity];
        try {
            foreach ($entities as $entity) {
                $this->em->persist($entity);
            }
            $this->em->flush();
            if ($clearEntityManager) {
                $this->em->clear();
            }
        } catch (ORMException | MappingException $e) {
            throw new DatabaseException("Entity save error", 0, $e);
        }
    }
}
