<?php

namespace SAREhub\MicroORM\Page;


class PageInfo
{
    const TOKEN_QUERY_PARAM = 'page_token';
    const SIZE_QUERY_PARAM = 'page_size';

    private $token = '0';
    private $size = 100;

    public function __construct(string $token, int $size)
    {
        $this->token = $token;
        $this->size = $size;
    }

    public static function createFromQueryParams(array $queryParams): PageInfo
    {
        return new self($queryParams[self::TOKEN_QUERY_PARAM] ?? '0', $queryParams[self::SIZE_QUERY_PARAM] ?? 100);
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