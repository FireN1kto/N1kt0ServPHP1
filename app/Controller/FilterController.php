<?php

namespace Controller;

use Src\Request;
use Model\Patient;
use Model\Doctor;
use Model\Appointment;
use Src\View;

class FilterController
{
    public function Filter(Request $request)
    {
        $filterType = $request->filter_type ?? 'appointments';
        $results = [];

        if ($request->method === 'POST') {
            switch ($filterType) {
                case 'patient_appointments':
                    $results = $this->filterPatientAppointments($request);
                    break;
                case 'doctor_schedule':
                    $results = $this->filterDoctorSchedule($request);
                    break;
                case 'patient_doctors':
                    $results = $this->filterPatientDoctors($request);
                    break;
                default:
                    $results = Appointment::with(['patient', 'doctor'])->get();
            }
        }

        return new View('officer.Filter', [
            'filterType' => $filterType,
            'results' => $results,
            'patients' => Patient::all(),
            'doctors' => Doctor::all(),
        ]);
    }

    private function filterPatientAppointments($request)
    {
        return Appointment::where('patient_id', $request->patient_id)
            ->with(['doctor', 'patient'])
            ->get();
    }

    private function filterDoctorSchedule($request)
    {
        return Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->date)
            ->with(['patient'])
            ->get();
    }

    private function filterPatientDoctors($request)
    {
        return Doctor::whereHas('appointments', function($q) use ($request) {
            $q->where('patient_id', $request->patient_id);
        })
            ->get();
    }
}