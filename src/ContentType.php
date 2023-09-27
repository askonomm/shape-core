<?php

namespace Asko\Shape\Core;

readonly class ContentType
{
    public function __construct(
        private string $name,
        private string $singular_name,
        private string $slug,
        private string $description,
        private array $fields,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSingularName(): string
    {
        return $this->singular_name;
    }

    public function getSlug(): string
    {
        return $this->slug;
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
