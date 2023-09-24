<?php

namespace Asko\Shape\Core;

use Asko\Hird\Hird;
use Asko\Shape\Core\Validators\SameValidator;

class Validator extends Hird
{
    public function __construct(
        private array $fields,
        private array $rules,
    ) {
        parent::__construct($fields, $rules);

        // Register validators
        $this->registerValidator("same", SameValidator::class);
    }
}
