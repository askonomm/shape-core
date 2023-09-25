<?php

namespace Asko\Shape\Core;

use Asko\Hird\Hird;
use Asko\Shape\Core\Validators\SameValidator;

class Validator extends Hird
{
    private array $fieldNames = [
        'email' => 'E-mail',
        'name' => 'Name',
        'password' => 'Password',
        'password_again' => 'Repeated password',
    ];

    public function __construct(
        private array $fields,
        private array $rules,
    ) {
        parent::__construct($fields, $rules);

        // Set field names
        $this->setFieldNames($this->fieldNames);

        // Register validators
        $this->registerValidator("same", SameValidator::class);
    }
}
