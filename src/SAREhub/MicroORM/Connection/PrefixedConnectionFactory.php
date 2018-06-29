<?php


namespace SAREhub\MicroORM\Connection;


use Doctrine\DBAL\Connection;

class PrefixedConnectionFactory implements ConnectionFactory
{
    /**
     * @var string
     */
    private $prefix;
    /**
     * @var ConnectionFactory
     */
    private $factory;

    public function __construct(string $prefix, ConnectionFactory $factory)
    {
        $this->prefix = $prefix;
        $this->factory = $factory;
    }

    public function createToDatabase(string $databaseName): Connection
    {
        return $this->factory->createToDatabase($this->getPrefixed($databaseName));
    }

    public function createToHost(): Connection
    {
        return $this->factory->createToHost();
    }

    public function hasPrefix(string $string): bool
    {
        return strpos($string, $this->getPrefix()) === 0;
    }

    public function stripPrefix(string $string): string
    {
        return substr($string, strlen($this->getPrefix()));
    }

    public function getPrefixed(string $string): string
    {
        return $this->getPrefix() . $string;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }
}