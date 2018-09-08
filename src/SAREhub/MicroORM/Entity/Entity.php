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

namespace SAREhub\MicroORM\Entity;


class Entity implements \JsonSerializable
{

    const ID_ENTRY = 'id';

    private $fields = [];

    public static function createFromArray(array $data)
    {
        $entity = new static();
        $entity->populateFromArray($data);
        return $entity;
    }

    public function getId()
    {
        return $this->get(self::ID_ENTRY);
    }

    public function setId($id)
    {
        $this->set(self::ID_ENTRY, $id);
    }

    public function hasId(): bool
    {
        return $this->has(self::ID_ENTRY);
    }

    public function get(string $field)
    {
        return $this->fields[$field];
    }

    public function set(string $field, $value)
    {
        $this->fields[$field] = $value;
    }

    public function has(string $field): bool
    {
        return isset($this->fields[$field]);
    }

    public function getAll(): array
    {
        return $this->fields;
    }

    public function getAllForInsertUpdate(): array
    {
        $fields = $this->fields;
        unset($fields[self::ID_ENTRY]);
        return $fields;
    }

    public function populateFromArray(array $data)
    {
        foreach ($data as $field => $value) {
            $this->set($field, $value);
        }
    }

    public function jsonSerialize()
    {
        return $this->fields;
    }

    public function __toString()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }
}