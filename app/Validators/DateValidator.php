<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class DateValidator extends AbstractValidator
{
    protected string $message = 'Поле :поле должно быть корректной датой';

    public function rule(): bool
    {
        if (empty($this->value)) return true;

        $date = \DateTime::createFromFormat('Y-m-d', $this->value);
        return $date && $date->format('Y-m-d') === $this->value;
    }
}
