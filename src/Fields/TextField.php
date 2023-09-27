<?php

namespace Asko\Shape\Core\Fields;

use Asko\Shape\Core\ContentField;

readonly class TextField extends ContentField
{
    public function __construct(
        string $identifier,
        string $name,
    ) {
        parent::__construct(
            identifier: $identifier,
            name: $name,
        );
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
