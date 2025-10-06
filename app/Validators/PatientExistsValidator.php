<?php
namespace Validators;

use Model\Patient;
use Src\Validator\AbstractValidator;

class PatientExistsValidator extends AbstractValidator
{
    protected string $message = 'Выбранный пациент не существует';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return false;
        }

        return Patient::where('id', (int)$this->value)->exists();
    }
}