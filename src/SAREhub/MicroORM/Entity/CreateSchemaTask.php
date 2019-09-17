<?php


namespace SAREhub\MicroORM\Entity;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use SAREhub\Commons\Task\Task;

class CreateSchemaTask implements Task
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function run()
    {
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->em);
        foreach ($schemaTool->getUpdateSchemaSql($metadata, true) as $sql) {
            $sql = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sql);
            $this->em->getConnection()->executeQuery($sql);
        }
    }
}
