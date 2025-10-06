<?php
namespace Validators;

use Model\Doctor;
use Src\Validator\AbstractValidator;

class DoctorExistsValidator extends AbstractValidator
{
    protected string $message = 'Выбранный врач не существует';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return false;
        }

        return Doctor::where('id', (int)$this->value)->exists();
    }
}