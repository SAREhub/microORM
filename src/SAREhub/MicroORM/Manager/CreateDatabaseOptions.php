<?php

namespace SAREhub\MicroORM\Manager;

class CreateDatabaseOptions
{
    const DEFAULT_CHARACTER_SET = "utf8mb4";
    const DEFAULT_COLLATE = "utf8mb4_unicode_ci";

    /**
     * @var string
     */
    private $characterSet;

    /**
     * @var string
     */
    private $collate;

    public function __construct(string $characterSet = self::DEFAULT_CHARACTER_SET, string $collate = self::DEFAULT_COLLATE)
    {
        $this->characterSet = $characterSet;
        $this->collate = $collate;
    }

    public function getCharacterSet(): string
    {
        return $this->characterSet;
    }

    public function getCollate(): string
    {
        return $this->collate;
    }
}