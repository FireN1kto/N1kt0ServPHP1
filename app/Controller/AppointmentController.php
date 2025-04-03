<?php

namespace Controller;

use Cassandra\Exception\ValidationException;
use Model\Appointment;
use Model\CreateInfo;
use Model\Doctor;
use Model\Patient;
use mysql_xdevapi\Exception;
use Src\Auth\Auth;
use Src\Request;
use Src\View;


class AppointmentController
{
    public function AppointmentList()
    {
        $appointments= Appointment::with([
            'patient',
            'doctor',
            'createInfo.user'
        ])->get();
        return new View('officer.listApointments', ['appointments' => $appointments]);
    }

    public function addAppointment(Request $request)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        if($request->method === "POST") {
            return $this->store($request);
        }

        return new View('officer.addAppointment', [
            'patients' => $patients,
            'doctors' => $doctors,
            'currentDate' => date('Y-m-d')
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validate($request);
            $this->chekDoctorAvailability(
                $validated['doctor_id'],
                $validated['appointment_date'],
                $validated['appointment_time']
            );

            $this->createAppointment($validated);
            return app()->route->redirect('/listAppointments');
        } catch (Exception $e) {
            return new View('officer.addAppointment', [
                'patients' => Patient::all(),
                'doctors' => Doctor::all(),
                'error' => $e->getMessage(),
                'old' => $request->all()
            ]);
        }
    }

    private function validate(Request $request): array
    {
        return $request->validate([
            'title' => ['required','string','min:15','max:255'],
            'appointment_date' => ['required','date', 'after_or_equal:today'],
            'appointment_time' => ['required'],
            'symptoms' => ['required','string','min:15','max:255'],
            'patient_id' => ['required','integer','exists:patients,id'],
            'doctor_id' => ['required','integer','exists:doctors,id'],
        ]);
    }

    private function chekDoctorAvailability(int $doctor_id, string $date, string $time): void
    {
        $exists = Appointment::where('doctor_id', $doctor_id)
            ->where('appointment_date', $date)
            ->where('appointment_time', $time)
            ->exists();

        if($exists) {
            throw new \Exception("Врач уже занят в это время");
        }
    }

    private function createAppointment(array $data): void
    {
        $createInfo = CreateInfo::create([
            'create_date' => date('Y-m-d'),
            'user_id' => Auth::user()->id
        ]);

        Appointment::addAppointment([
            'title' => $data['title'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'symptoms' => $data['symptoms'],
            'patient_id' => $data['patient_id'],
            'doctor_id' => $data['doctor_id'],
            'createInfo_id' => $createInfo->id
        ]);
    }
}