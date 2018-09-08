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