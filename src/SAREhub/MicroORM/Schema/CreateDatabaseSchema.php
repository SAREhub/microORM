<?php


namespace SAREhub\MicroORM\Schema;


use Doctrine\DBAL\Platforms\AbstractPlatform;

class CreateDatabaseSchema
{
    private const SQL_QUERY_FORMAT = "CREATE DATABASE %s CHARACTER SET %s COLLATE %s";

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $characterSet;

    /**
     * @var string
     */
    private $collate;

    public static function newInstance(): self
    {
        return new self();
    }

    public function setName(string $name): CreateDatabaseSchema
    {
        $this->name = $name;
        return $this;
    }

    public function setCharacterSet(string $characterSet): CreateDatabaseSchema
    {
        $this->characterSet = $characterSet;
        return $this;
    }

    public function setCollate(string $collate): CreateDatabaseSchema
    {
        $this->collate = $collate;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCharacterSet(): string
    {
        return $this->characterSet;
    }

    public function getCollate(): string
    {
        return $this->collate;
    }

    public function toSql(AbstractPlatform $platform): string
    {
        return sprintf(self::SQL_QUERY_FORMAT, $this->getName(), $this->getCharacterSet(), $this->getCollate());
    }

}