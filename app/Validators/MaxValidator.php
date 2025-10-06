<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class MaxValidator extends AbstractValidator
{
    protected string $message = 'Поле :поле должно содержать максимум :max символов';

    public function rule(): bool
    {
        if (empty($this->value)) return true;

        return strlen(trim($this->value)) <= (int)$this->args[0];
    }
}
