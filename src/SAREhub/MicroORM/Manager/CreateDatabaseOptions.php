<?php
/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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