<?php

namespace Controller;

use Model\Patient;
use Model\CreatedInfo;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class PatientController
{
    public function createPatient(Request $request): string
    {
        $errors = [];
        if ($request->method === "POST") {
            $validator = new \Src\Validator\Validator($request->all(), [
                'surname' => ['required'],
                'name' => ['required'],
                'patronymic' => ['required'],
                'dateOfBirth' => ['required', 'date']
            ], [
                'required' => 'Поле :field пусто',
                'date' => 'Поле :field должно быть корректной датой'
            ]);

            if ($validator->fails()) {
                return new View('officer.create-patient', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            $createInfo = CreatedInfo::create([
                'creation_date' => date('Y-m-d'),
                'user_id' => Auth::user()->id
            ]);

            $patient = new Patient([
                'surname' => $request->surname,
                'name' => $request->name,
                'patronymic' => $request->patronymic,
                'dateOfBirth' => $request->dateOfBirth,
                'createInfo_id' => $createInfo->id
            ]);

            if ($patient->save()) {
                return app()->route->redirect('/listPatients');
            }
        }

        return new View('officer.create-patient');
    }

    public function listPatients(): string
    {
        $patients = Patient::all();
        return new View('officer.listPatients', ['patients' => $patients]);
    }
}