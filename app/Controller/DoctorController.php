<?php

namespace Controller;

use Model\Doctor;
use Model\Patient;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class DoctorController
{
    public function createDoctor(Request $request): string
    {
        return new View ('officer.create-doctor');
    }

    public function store(Request $request)
    {
        if (empty($request->surname) || strlen($request->surname) < 2) {
            return new View('officer.create-doctor', [
                'error' => "Фамилия должна содержать минимум 2 символа",
                'old' => $request->all()
            ]);
        }
        if (empty($request->name) || strlen($request->name) < 2) {
            return new View('officer.create-doctor', [
                'error' => "Имя должно содержать минимум 2 символа",
                'old' => $request->all()
            ]);
        }
        if (empty($request->patronymic) || strlen($request->patronymic) < 2) {
            return new View('officer.create-doctor', [
                'error' => "Отчество должно содержать минимум 2 символа",
                'old' => $request->all()
            ]);
        }
        if (empty($request->birth_date)) {
            return new View('officer.create-doctor', [
                'error' => "Укажите дату рождения",
                'old' => $request->all()
            ]);
        }
        if (empty($request->specialization)) {
            return new View('officer.create-doctor', [
                'error' => 'Укажите специализацию',
                'old' => $request->all()
            ]);
        }
        $doctor = new Doctor();
        $doctor->surname = $request->surname;
        $doctor->name = $request->name;
        $doctor->patronymic = $request->patronymic ?? null;
        $doctor->birth_date = $request->birth_date;
        $doctor->specialization = $request->specialization;
        $doctor->position = $request->position ?? 'Врач';

        if ($doctor->save()) {
            return app() ->route->redirect('/listDoctors');
        }
        return new View('officer.create-doctor', [
            'error' => "Ошибка при создании пациента",
            'old' => $request->all()
        ]);
    }

    public function listDoctors(): string
    {
        $doctors = Doctor::all();
        return new View('officer.listDoctor', ['doctors' => $doctors]);
    }
}