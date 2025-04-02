<?php

namespace Middlewares;

use Model\User;
use Src\Auth\Auth;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name_role !== 'admin') {
            app()->route->redirect('/hello');
        }
    }
}