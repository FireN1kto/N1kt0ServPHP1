<?php

namespace Controller;

use Model\Appointment;
use Model\CreatedInfo;
use Model\Doctor;
use Model\Patient;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class AppointmentController
{
    public function AppointmentList(Request $request): string
    {
        // Проверяем, была ли нажата кнопка "Отменить запись"
        if ($request->method === 'POST' && !empty($request->delete_appointment_id)) {
            $id = (int)$request->delete_appointment_id;
            $appointment = Appointment::find($id);
            if ($appointment) {
                $appointment->delete();
            }
        }

        $appointments = Appointment::with([
            'patient',
            'doctor',
            'createInfo.user'
        ])->get();

        return new View('officer.listAppointments', ['appointments' => $appointments]);
    }

    public function addAppointment(Request $request): string
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        if ($request->method === "POST") {
            $validator = new \Src\Validator\Validator($request->all(), [
                'title' => ['required', 'min:5', 'max:255'],
                'appointment_date' => ['required', 'date'],
                'symptoms' => ['required', 'min:10', 'max:1000'],
                'patient_id' => ['required', 'patient_exists'],
                'doctor_id' => ['required', 'doctor_exists']
            ], [
                'required' => 'Поле :field пусто',
                'min' => 'Поле :field должно содержать минимум :min символов',
                'max' => 'Поле :field должно содержать максимум :max символов',
                'date' => 'Поле :field должно быть корректной датой',
                'patient_exists' => 'Выбранный пациент не существует',
                'doctor_exists' => 'Выбранный врач не существует'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return new View('officer.addAppointment', [
                    'patients' => $patients,
                    'doctors' => $doctors,
                    'currentDate' => date('Y-m-d'),
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            $patient_id = $request->patient_id;
            $doctor_id = $request->doctor_id;

            $patient = Patient::find($patient_id);
            $doctor = Doctor::find($doctor_id);

            if (!$patient || !$doctor) {
                return new View('officer.addAppointment', [
                    'patients' => $patients,
                    'doctors' => $doctors,
                    'currentDate' => date('Y-m-d'),
                    'error' => 'Выбранный пациент или врач не существует.'
                ]);
            }
        }
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/public/img/diagnosis/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = $_FILES['image']['type'];

            if (in_array($fileType, $allowedTypes)) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid() . '_' . time() . '.' . $extension;
                $imagePath = '/img/diagnosis/' . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $imagePath = '/img/diagnosis/' . $fileName;
                }
            }
        }

        if ($request->method === "POST") {
            $createInfo = CreatedInfo::create([
                'create_date' => date('Y-m-d'),
                'user_id' => Auth::user()->id
            ]);

            $appointment = new Appointment([
                'title' => $request->title,
                'appointment_date' => $request->appointment_date,
                'symptoms' => $request->symptoms,
                'image' => $imagePath,
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'createInfo_id' => $createInfo->id,
            ]);

            if ($appointment->save()) {
                return app()->route->redirect('/listAppointments');
            }
        }

        return new View('officer.addAppointment', [
            'patients' => $patients,
            'doctors' => $doctors,
            'currentDate' => date('Y-m-d')
        ]);
    }
}