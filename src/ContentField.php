<?php

namespace Asko\Shape\Core;

use Asko\Shape\Core\Interfaces\ContentFieldInterface;

readonly class ContentField implements ContentFieldInterface
{
    /**
     * @param string $identifier
     * @param string $name
     */
    public function __construct(
        private string $identifier,
        private string $name,
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

    public function getEditable(): callable
    {
        return function (string $content_id, string $value): string {
            return $value;
        };
    }

    public function getViewable(): callable
    {
        return function (string $content_id, string $value): string {
            return $value;
        };
    }
}
