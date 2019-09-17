<?php

namespace SAREhub\MicroORM;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\ORMException;

class DatabaseException extends \RuntimeException
{
    public static function createFromOrm(ORMException $e, string $message): self
    {
        return new self($message, 0, $e);
    }

    public static function createFromDBAL(DBALException $e, string $message): self
    {
        return new self($message, 0, $e);
    }
}
