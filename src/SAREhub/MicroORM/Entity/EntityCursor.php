<?php

namespace SAREhub\MicroORM\Entity;


use Doctrine\DBAL\Driver\Statement;

class EntityCursor implements \Iterator
{

    /**
     * @var EntityRepository
     */
    private $repo;

    /**
     * @var \Iterator
     */
    private $it;

    public function __construct(EntityRepository $repo, Statement $st)
    {
        $this->repo = $repo;
        $st->setFetchMode(\PDO::FETCH_ASSOC);
        $this->it = new \IteratorIterator($st);
    }

    public function current()
    {
        $data = $this->getIterator()->current();
        return $this->createFromArray($data);
    }

    public function next()
    {
        $this->getIterator()->next();
    }

    public function key()
    {
        return $this->getIterator()->key();
    }

    public function valid()
    {
        return $this->getIterator()->valid();
    }

    public function rewind()
    {
        $this->getIterator()->rewind();
    }

    private function createFromArray(array $data): Entity
    {
        return $this->repo->createFromArray($data);
    }

    private function getIterator(): \Iterator
    {
        return $this->it;
    }
}