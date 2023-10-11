<?php

namespace Asko\Shape\Core;

readonly class ContentType
{
    /**
     * @param string $identifier
     * @param string $name
     * @param string $singular_name
     * @param string $description
     * @param ContentField[] $fields
     * @param array $list_view
     */
    public function __construct(
        private string $identifier,
        private string $name,
        private string $singular_name,
        private string $description,
        private array $fields,
        private array $list_view = [],
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

    public function getField(string $identifier): ?ContentField
    {
        foreach($this->getFields() as $field) {
            if ($field->getIdentifier() === $identifier) {
                return $field;
            }
        }

        return null;
    }

    public function getListViewFields(): array
    {
        return $this->list_view["fields"] ?? [];
    }

    public function getListViewSortFn(): ?callable
    {
        return $this->list_view["sort_fn"] ?? null;
    }
}
