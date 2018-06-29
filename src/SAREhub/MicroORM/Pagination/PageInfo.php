<?php

namespace SAREhub\MicroORM\Pagination;


class PageInfo
{

    const DEFAULT_SIZE = 100;
    const DEFAULT_TOKEN = '0';

    private $token = self::DEFAULT_TOKEN;
    private $size = self::DEFAULT_SIZE;

    public function __construct(string $token, int $size)
    {
        $this->token = $token;
        $this->size = $size;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}