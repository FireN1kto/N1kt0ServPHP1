<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class ImageValidator extends AbstractValidator
{
    protected string $message = 'Файл должен быть изображением (JPG, PNG, GIF)';

    public function rule(): bool
    {
        if (empty($this->value['name'])) return true;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        return in_array($this->value['type'], $allowedTypes);
    }
}
