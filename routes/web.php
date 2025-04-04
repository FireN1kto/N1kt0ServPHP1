<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add(['GET', 'POST'], '/create-officer', [Controller\AdminController::class, 'createOfficer'])
    ->middleware('auth','admin');
Route::add(['GET', 'POST'], '/officers-list', [Controller\AdminController::class, 'officerList'])
    ->middleware('auth','admin');
Route::add(['GET', 'POST'], '/listAppointments', [Controller\AppointmentController::class, 'AppointmentList'])
    ->middleware('auth','officer');
Route::add(['GET', 'POST'], '/addAppointment', [Controller\AppointmentController::class, 'addAppointment'])
    ->middleware('auth','officer');
Route::add(['GET', 'POST'], '/create-patient', [Controller\PatientController::class, 'createPatient'])
    ->middleware('auth','officer');
Route::add(['GET', 'POST'], '/create-doctor', [Controller\DoctorController::class, 'createDoctor'])
    ->middleware('auth','officer');