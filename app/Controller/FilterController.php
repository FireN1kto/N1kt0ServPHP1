<?php

namespace Controller;

use Src\Request;
use Model\Patient;
use Model\Doctor;
use Model\Appointment;
use Src\View;

class FilterController
{
    {
        $results = [];

            switch ($filterType) {
                case 'patient_appointments':
                    break;
                case 'doctor_schedule':
                    break;
                case 'patient_doctors':
                    break;
                default:
                    $results = Appointment::with(['patient', 'doctor'])->get();
            }
        }

        return new View('officer.Filter', [
            'filterType' => $filterType,
            'results' => $results,
        ]);
    }

    {
            ->with(['doctor', 'patient'])
            ->get();
    }

    {
            ->with(['patient'])
            ->get();
    }

    {
        })
            ->get();
    }
}