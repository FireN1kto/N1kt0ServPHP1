<?php

namespace Controller;

use Src\Request;
use Model\Patient;
use Model\Doctor;
use Model\Appointment;
use Src\View;

class FilterController
{
    public function Filter(Request $request):string
    {
        $params = $request->all();
        $filterType = $params['filter_type'] ?? 'appointments';

        $results = [];
        $patients = Patient::all();
        $doctors = Doctor::with('position')->get();

        if (!empty($params)) {
            switch ($filterType) {
                case 'patient_appointments':
                    if (isset($params['patient_id'])) {
                        $results = $this->filterPatientAppointments($params['patient_id']);
                    }
                    break;

                case 'doctor_schedule':
                    if (isset($params['doctor_id'], $params['date'])) {
                        $results = $this->filterDoctorSchedule($params['doctor_id'], $params['date']);
                    }
                    break;

                case 'patient_doctors':
                    if (isset($params['patient_id'])) {
                        $results = $this->filterPatientDoctors($params['patient_id']);
                    }
                    break;

                default:
                    $results = Appointment::with(['patient', 'doctor'])->get();
            }
        }

        return new View('officer.Filter', [
            'filterType' => $filterType,
            'results' => $results,
            'patients' => $patients,
            'doctors' => $doctors,
        ]);
    }

    private function filterPatientAppointments($patientId)
    {
        return Appointment::where('patient_id', $patientId)
            ->with(['doctor', 'patient'])
            ->get();
    }

    private function filterDoctorSchedule($doctorId, $date)
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->with(['patient'])
            ->get();
    }

    private function filterPatientDoctors($patientId)
    {
        return Doctor::whereHas('appointments', function($q) use ($patientId) {
            $q->where('patient_id', $patientId);
        })
            ->with('position')
            ->get();
    }
}