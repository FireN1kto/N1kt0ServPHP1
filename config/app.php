<?php
return [
    'auth' => \Src\Auth\Auth::class,
    'identity' => \Model\User::class,
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
        'officer' => \Middlewares\OfficerMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'unique_officer' => \Validators\UniqueOfficerValidator::class,
        'date' => \Validators\DateValidator::class,
        'doctor_exists' => \Validators\DoctorExistsValidator::class,
        'patient_exists' => \Validators\PatientExistsValidator::class,
        'min' => \Validators\MinValidator::class,
        'max' => \Validators\MaxValidator::class,
        'image' => \Validators\ImageValidator::class
    ],
    'routeAppMiddleware' => [
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class
    ],
];
