<?php

namespace Middlewares;

use Model\User;
use Src\Auth\Auth;
use Src\Request;

class OfficerMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();
        if ($user->role_id->name_role == 'registration_officer') {
            app()->route->redirect('/hello');
        }
    }
}