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
        if ($request->method === "POST") {
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