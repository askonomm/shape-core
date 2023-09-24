<?php

namespace Asko\Shape\Core\Validators;

use Asko\Hird\Validators\Validator;

class SameValidator implements Validator
{
    public function __construct(private array $fields)
    {
    }

    public function validate(string $field, mixed $value, mixed $modifier = null): bool
    {
        return $value === $this->fields[$modifier];
    }

    public function composeError(string $field, mixed $modifier = null): string
    {
        return "{$field} is not equal to {$modifier}.";
    }
}
