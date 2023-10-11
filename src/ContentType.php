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
     * @param array $list_view_fields
     * @param string|null $list_view_sort_by
     * @param string|null $list_view_order
     */
    public function __construct(
        private string $identifier,
        private string $name,
        private string $singular_name,
        private string $description,
        private array $fields,
        private array $list_view_fields,
        private ?string $list_view_sort_by = null,
        private ?string $list_view_order = null,
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
        return $this->list_view_fields;
    }

    public function getListViewSortBy(): ?string
    {
        return $this->list_view_sort_by;
    }

    public function getListViewOrder(): ?string
    {
        return $this->list_view_order;
    }
}
