<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class MinValidator extends AbstractValidator
{
    protected string $message = 'Поле :поле должно содержать минимум :min символов';

    public function rule(): bool
    {
        if (empty($this->value)) return true;

        return strlen(trim($this->value)) >= (int)$this->args[0];
    }
}
