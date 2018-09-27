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


use SAREhub\MicroORM\DatabaseException;

interface DatabaseManager
{

    /**
     * @param string $name
     * @param null|CreateDatabaseOptions $options
     * @throws DatabaseException
     */
    public function create(string $name, ?CreateDatabaseOptions $options = null): void;

    /**
     * @param string $name
     * @throws DatabaseException
     */
    public function drop(string $name);

    /**
     * @param string $name
     * @return bool
     */
    public function exists(string $name): bool;

    /**
     * @return array
     */
    public function getList(): array;
}