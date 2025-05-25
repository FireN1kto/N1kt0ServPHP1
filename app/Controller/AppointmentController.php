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

        // Получаем актуальный список записей
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

        if ($request->method === "POST") {
            $createInfo = CreatedInfo::create([
                'create_date' => date('Y-m-d'),
                'user_id' => Auth::user()->id
            ]);

            $appointment = new Appointment([
                'title' => $request->title,
                'appointment_date' => $request->appointment_date,
                'symptoms' => $request->symptoms,
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