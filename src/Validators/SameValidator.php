<?php

use Asko\Hird\Validators\Validator;

class SameValidator implements Validator
{
    public function validate(string $field, mixed $value, mixed $modifier = null): bool
    {
        return $value === $modifier;
    }

    public function composeError(string $field, mixed $modifier = null): string
    {
        return "";
    }
}
