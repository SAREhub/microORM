<?php


namespace SAREhub\MicroORM\Processor\Entity;


use Doctrine\ORM\EntityManager;
use SAREhub\Client\Message\Exchange;
use SAREhub\Client\Processor\Processor;

class ClearEntityManagerProcessor implements Processor
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function process(Exchange $exchange)
    {
        $this->em->clear();
    }
}
