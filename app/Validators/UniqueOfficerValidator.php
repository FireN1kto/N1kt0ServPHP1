<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Model\Role;
use Src\Validator\AbstractValidator;

class UniqueOfficerValidator extends AbstractValidator
{
    protected string $message = 'Сотрудник с таким именем и логином уже существует';

    public function rule(): bool
    {
        if (empty($this->value) || empty($this->args[0])) {
            return true;
        }
        $officerRole = Role::where('name_role', 'registration_officer')->first();

        if (!$officerRole) {
            return true;
        }

        $name = $this->value;
        $login = $this->args[0];

        $existingOfficer = Capsule::table('users')
            ->where('name', $name)
            ->where('login', $login)
            ->where('role_id', $officerRole->id)
            ->count();

        return $existingOfficer === 0;
    }
}
