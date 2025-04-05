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
        if (!$user || $user->role->name_role !== 'registration_officer') {
            app()->route->redirect('/hello');
            return false;
        }
        error_log('OfficerMiddleware executed for user: ' . Auth::user()->id);
        return true;
    }
}