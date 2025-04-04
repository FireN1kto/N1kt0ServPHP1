<?php

namespace Controller;

use Model\Appointment;
use Model\CreateInfo;
use Model\Doctor;
use Model\Patient;
use Src\Auth\Auth;
use Src\Request;
use Src\View;


class AppointmentController
{
    public function AppointmentList(Request $request): string
    {
        $appointments= Appointment::with([
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

        if($request->method === "POST") {
            $result = $this->store($request);
            if($result === true) {
                return app()->route->redirect('/listApointments');
            }
            return new View('officer.addAppointment', [
                'patients' => Patient::all(),
                'doctors' => Doctor::all(),
                'error' => $result,
                'old' => $request->all()
            ]);
        }

        return new View('officer.addAppointment', [
            'patients' => $patients,
            'doctors' => $doctors,
            'currentDate' => date('Y-m-d')
        ]);
    }

    public function store(Request $request)
    {
        if(empty($request->title) || strlen($request->title) < 15) {
            return "название записи должно содержать минимум 15 символов";
        }
        if (empty($request->appointment_date) || strtotime($request->appointment_date) < strtotime('today')) {
            return "Дата приема не может быть в прошлом";
        }
        if (empty($request->appointment_time)) {
            return "Укажите время приема";
        }
        if (empty($request->symptoms) || strlen($request->symptoms) < 15) {
            return "Описание симптомов должно содержать минимум 15 символов";
        }
        if (empty($request->patient_id) || !Patient::find($request->patient_id)) {
            return "Укажите корректного пациента";
        }
        if (empty($request->doctor_id) || !Doctor::find($request->doctor_id)) {
            return "Укажите корректного врача";
        }

        $isBusy = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($isBusy) {
            return "Врач уже занят в это время";
        }

        $createInfo = CreateInfo::create([
            'create_date' => date('Y-m-d'),
            'user_id' => Auth::user()->id
        ]);

        $appointment = new Appointment();
        $appointment->title = $request->title;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->symptoms = $request->symptoms;
        $appointment->patient_id = $request->patient_id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->{'create-info_id'} = $createInfo->id;

        if ($appointment->save()) {
            return true;
        }

        return "Ошибка при создании записи";
    }
}