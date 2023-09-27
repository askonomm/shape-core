<?php

namespace Asko\Shape\Core;

readonly class ContentType
{
    /**
     * @param string $identifier
     * @param string $name
     * @param string $singular_name
     * @param string $description
     * @param ContentFieldInterface[] $fields
     */
    public function __construct(
        private string $identifier,
        private string $name,
        private string $singular_name,
        private string $description,
        private array $fields,
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSingularName(): string
    {
        return $this->singular_name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}
