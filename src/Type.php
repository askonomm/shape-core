<?php

namespace Asko\Shape\Core;

class Type
{
    private string $identifier;
    private string $name;
    private string $singular_name;
    private array $fields = [];
    private array $list_view_fields;
    private ?string $list_view_sort_by = null;
    private ?string $list_view_order = null;

    public function withIdentifier(string $identifier): Type
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function withName(string $name, string $singularName = ''): Type
    {
        $this->name = $name;
        $this->singular_name = $singularName;

        return $this;
    }

    public function withFields(Field ...$fields): Type
    {
        $this->fields = $fields;

        return $this;
    }

    public function withListViewFields(string ...$fields): Type
    {
        $this->list_view_fields = $fields;

        return $this;
    }

    public function withListViewSortBy(string $sortBy): Type
    {
        $this->list_view_sort_by = $sortBy;

        return $this;
    }

    public function withListViewOrder(string $order): Type
    {
        $this->list_view_order = $order;

        return $this;
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

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getField(string $identifier): ?Field
    {
        foreach ($this->getFields() as $field) {
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
