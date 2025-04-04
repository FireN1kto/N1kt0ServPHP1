<?php

namespace Controller;

use Model\Patient;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class PatientController
{
    public function createPatient(Request $request)
    {
        return new View ('officer.create-patient');
    }

    public function store(Request $request)
    {
        if (empty($request->surname) || strlen($request->surname) < 2) {
            return new View('officer.create-patient', [
                'error' => "Фамилия должна содержать минимум 2 символа",
                'old' => $request->all()
            ]);
        }
        if (empty($request->name) || strlen($request->name) < 2) {
            return new View('officer.create-patient', [
                'error' => "Имя должно содержать минимум 2 символа",
                'old' => $request->all()
            ]);
        }
        if (empty($request->patronymic) || strlen($request->patronymic) < 2) {
            return new View('officer.create-patient', [
                'error' => "Отчество должно содержать минимум 2 символа",
                'old' => $request->all()
            ]);
        }
        if (empty($request->birth_date)) {
            return new View('officer.create-patient', [
                'error' => "Укажите дату рождения",
                'old' => $request->all()
            ]);
        }
        $patient = new Patient();
        $patient->surname = $request->surname;
        $patient->name = $request->name;
        $patient->patronymic = $request->patronymic ?? null;
        $patient->birth_date = $request->birth_date;

        if ($patient->save()) {
            return app() ->route->redirect('/listPatients');
        }
        return new View('officer.create-patient', [
            'error' => "Ошибка при создании пациента",
            'old' => $request->all()
        ]);
    }

    public function listPatients()
    {
        $patients = Patient::all();
        return new View('officer.listPatients', ['patients' => $patients]);
    }
}