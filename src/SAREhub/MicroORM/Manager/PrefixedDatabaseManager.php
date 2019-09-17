<?php


namespace SAREhub\MicroORM\Manager;


class PrefixedDatabaseManager implements DatabaseManager
{
    /**
     * @var DatabaseManager
     */
    private $decorated;

    /**
     * @var string
     */
    private $prefix;


    public function __construct(string $prefix, DatabaseManager $decorated)
    {
        $this->decorated = $decorated;
        $this->prefix = $prefix;
    }

    public function create(string $name, ?CreateDatabaseOptions $options = null): void
    {
        $this->decorated->create($this->getPrefixed($name), $options);
    }

    public function drop(string $name): void
    {
        $this->decorated->drop($this->getPrefixed($name));
    }

    public function exists(string $name): bool
    {
        return $this->decorated->exists($this->getPrefixed($name));
    }

    public function getList(): array
    {
        $list = [];
        foreach ($this->decorated->getList() as $name) {
            if ($this->hasPrefix($name)) {
                $list[] = $this->stripPrefix($name);
            }
        }
        return $list;
    }

    private function getPrefixed(string $name): string
    {
        return $this->prefix . $name;
    }

    private function hasPrefix(string $name)
    {
        return strpos($name, $this->prefix) === 0;
    }

    private function stripPrefix(string $name)
    {
        return substr($name, strlen($this->prefix));
    }
}
