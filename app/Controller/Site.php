<?php

namespace Controller;

use Model\Post;
use Model\User;
use Model\Role;
use Src\View;
use Src\Request;
use Src\Auth\Auth;

class Site
{
    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function signup(Request $request): string
    {
        $roles = Role::all();
        $allowAdmin = !User::adminExists();

        if ($request->method === 'POST') {
            $data = $request->all();
            if (!$allowAdmin) {
                $data['role_id'] = Role::where('name_role', 'user')->first()->id;
            } else {
                $data['role_id'] = $request->role_id;
            }
            if(User::create($data)) {
                Auth::attempt($data);
                return app()->route->redirect('/hello');
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