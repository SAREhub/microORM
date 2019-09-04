<?php

namespace SAREhub\MicroORM;

use Doctrine\DBAL\DBALException;

class DatabaseException extends \RuntimeException
{
    public static function createFromDBAL(DBALException $e, string $message): self
    {
        return new self($message, 0, $e);
    }
}