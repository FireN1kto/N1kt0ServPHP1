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
            $data = $request->all();
            $data['role_id'] = Role::where('name_role', 'registration_officer')->first()->id;

            User::create($data);
            return redirect('/admin/officers-list');
        }

        return new View('admin.create-officer');
    }

    public function deleteOfficer(Request $request): void
    {
        $officer = User::find($request->id);

        if ($officer && $officer->role_id->name_role == 'registration_officer') {
            $officer->delete();
        }

        app()->route->redirect('/admin/officers');
    }

    public function officerList(Request $request): string
    {
        $officers = User::whereHas('role', function ($query) {
            $query->where('name_role', 'registration_officer');
        })->get();

        return new View('admin.officers-list', ['officers' => $officers]);
    }
}