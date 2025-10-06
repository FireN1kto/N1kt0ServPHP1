<?php

namespace Controller;

use Model\User;
use Model\Role;
use Src\Request;
use Src\View;

class AdminController
{
    public function createOfficer(Request $request): string
    {
        if($request->method == 'POST'){
            $validator = new \Src\Validator\Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required', 'min:4']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'min' => 'Пароль должен содержать минимум 4 символов'
            ]);
            $allErrors = [];

            if ($validator->fails()) {
                $allErrors = $validator->errors();
            }

            $officerRole = Role::where('name_role', 'registration_officer')->first();
            if ($officerRole) {
                $existingOfficer = User::where('name', $request->name)
                    ->where('login', $request->login)
                    ->where('role_id', $officerRole->id)
                    ->first();

                if ($existingOfficer) {
                    $allErrors['name'][] = 'Сотрудник с таким именем и логином уже существует';
                }
            }
            if (!empty($allErrors)) {
                $officers = User::all();
                return new View('admin.create-officer', [
                    'officers' => $officers,
                    'errors' => $allErrors
                ]);
            }
            $data = $request->all();
            $data['role_id'] = Role::where('name_role', 'registration_officer')->first()->id;

            User::create($data);
            app()->route->redirect('/officers-list');
        }
        $officers = User::all();

        return new View('admin.create-officer', ['officers' => $officers]);
    }

    public function deleteOfficer(Request $request): void
    {
        $officer = User::find($request->id);

        if ($officer && $officer->role_id->name_role == 'registration_officer') {
            $officer->delete();
        }

        app()->route->redirect('/officers-list');
    }

    public function officerList(Request $request): string
    {
        $officers = User::whereHas('role', function ($query) {
            $query->where('name_role', 'registration_officer');
        })->get();
        return new View('admin.officers-list', ['officers' => $officers]);
    }
}