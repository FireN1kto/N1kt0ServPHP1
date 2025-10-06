<?php

namespace Controller;

use Model\Doctor;
use Model\CreatedInfo;
use Model\Position;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class DoctorController
{
    public function createDoctor(Request $request): string
    {
        $positions = Position::all();
        $errors = [];
        if ($request->method === "POST") {
            $validator = new \Src\Validator\Validator($request->all(), [
                'surname' => ['required'],
                'name' => ['required'],
                'patronymic' => ['required'],
                'dateOfBirth' => ['required', 'date'],
                'specialization' => ['required', 'min:4']
            ], [
                'required' => 'Поле :field пусто',
                'date' => 'Поле :field должно быть корректной датой',
                'min' => 'Поле :field должно содержать минимум 4 символов'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return new View('officer.create-doctor', [
                    'positions' => $positions,
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            $createInfo = CreatedInfo::create([
                'creation_date' => date('Y-m-d'),
                'user_id' => Auth::user()->id
            ]);

            $doctor = new Doctor([
                'surname' => $request->surname,
                'name' => $request->name,
                'patronymic' => $request->patronymic,
                'dateOfBirth' => $request->dateOfBirth,
                'specialization' => $request->specialization,
                'position_id' => $request->position_id,
                'createInfo_id' => $createInfo->id
            ]);

            if ($doctor->save()) {
                return app()->route->redirect('/listDoctors');
            }
        }

        return new View('officer.create-doctor', ['positions' => $positions]);
    }

    public function listDoctors(): string
    {
        $doctors = Doctor::all();
        return new View('officer.listDoctors', ['doctors' => $doctors]);
    }
}