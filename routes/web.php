<?php

use App\Http\Controllers\{
    CheckupController,
    ProfileController,
    DashboardController,
    DoctorScheduleController,
    ICD10Controller,
    MedicineController,
    PatientController,
    PoliController,
    PreCheckupController,
    RegistrationController,
    ServiceController,
    UserController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/user', UserController::class);
    Route::resource('/poli', PoliController::class);
    Route::resource('/service', ServiceController::class);

    Route::get('/doctor-schedule/{userId}/data', [DoctorScheduleController::class, 'data'])->name('doctor-schedule.data');
    Route::resource('/doctor-schedule', DoctorScheduleController::class);
    Route::resource('/patient', PatientController::class);
    Route::resource('/medicine', MedicineController::class);
    Route::resource('/icd10', ICD10Controller::class);

    Route::get('/registration/patient', [RegistrationController::class, 'searchPatient'])->name('registration.patient');
    Route::get('/registration/patient/{patientId}', [RegistrationController::class, 'selectPatient'])->name('registration.patient.select');
    Route::get('/registration/doctor/{poliId}/{date}', [RegistrationController::class, 'getDoctorByPoli'])->name('registration.doctor');
    Route::get('/registration/doctor-schedule/{poliId}/{date}/{userId}', [RegistrationController::class, 'getDoctorSchedule'])->name('registration.doctor.schedule');
    Route::resource('/registration', RegistrationController::class);

    Route::post('/checkup/patient/disease', [CheckupController::class, 'createPatientDisease'])->name('checkup.patient.disease.store');
    Route::delete('/checkup/patient/disease/{diseaseId}', [CheckupController::class, 'destroyPatientDisease'])->name('checkup.patient.disease.destroy');
    Route::post('/checkup/patient/allergy', [CheckupController::class, 'createPatientAllergy'])->name('checkup.patient.allergy.store');
    Route::delete('/checkup/patient/allergy/{allergyId}', [CheckupController::class, 'destroyPatientAllergy'])->name('checkup.patient.allergy.destroy');

    Route::get('/checkup/icd10', [CheckupController::class, 'getICD10'])->name('checkup.icd10');
    Route::get('/checkup/medicine', [CheckupController::class, 'searchMedicine'])->name('checkup.medicine');
    Route::resource('/checkup', CheckupController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
