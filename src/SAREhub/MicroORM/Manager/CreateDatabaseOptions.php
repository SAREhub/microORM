<?php


namespace SAREhub\MicroORM\Manager;

class CreateDatabaseOptions
{

    const DEFAULT_CHARACTER_SET = "utf8mb4";

    /**
     * @var string
     */
    private $characterSet = self::DEFAULT_CHARACTER_SET;

    const DEFAULT_COLLATE = "utf8mb4_unicode_ci";

    /**
     * @var string
     */
    private $collate = self::DEFAULT_COLLATE;

    const DEFAULT_IF_NOT_EXISTS = false;

    /**
     * @var bool
     */
    private $ifNotExists = self::DEFAULT_IF_NOT_EXISTS;

    public function newInstance(): self
    {
        return new self();
    }

    public function getCharacterSet(): string
    {
        return $this->characterSet;
    }

    public function setCharacterSet(string $characterSet): CreateDatabaseOptions
    {
        $this->characterSet = $characterSet;
        return $this;
    }

    public function getCollate(): string
    {
        return $this->collate;
    }

    public function setCollate(string $collate): CreateDatabaseOptions
    {
        $this->collate = $collate;
        return $this;
    }

    public function isIfNotExists(): bool
    {
        return $this->ifNotExists;
    }

    public function setIfNotExists(bool $ifNotExists): CreateDatabaseOptions
    {
        $this->ifNotExists = $ifNotExists;
        return $this;
    }
}
