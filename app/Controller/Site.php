<?php

namespace Controller;

use Model\User;
use Model\Role;
use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Validator\Validator;

class Site
{

    public function hello(): string
    {
        $user = Auth::user();

        if($user->role->name_role == 'admin'){
            return new View('admin.hello', ['message' => 'Панель администратора']);
        } elseif ($user->role->name_role == 'registration_officer'){
            return new View('officer.hello', ['message' => 'Панель сотрудника регистрации']);
        } else{
            return new View('site.hello', ['message' => 'Гостевое посещение']);
        }
    }

    public function signup(Request $request): string
    {
        $roles = Role::all();
        $allowAdmin = !User::adminExists();
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup', [
            'roles' => $roles,
            'allowAdmin' => $allowAdmin,
        ]);
    }

    public function login(Request $request): string
    {
        if ($request->method==='GET'){
            return new View('site.login');
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}