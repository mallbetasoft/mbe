<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DoctorController;
use App\Http\Controllers\Api\V1\BillingSheetController;
use App\Http\Controllers\Api\V1\PatientController;
use App\Http\Controllers\Api\V1\ContactUsController;
use App\Http\Controllers\SSOController;

/*
|--------------------------------------------------------------------------
| API/V1 Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application V1. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 

Route::prefix("apiV1")->group(function(){
    // doctor login
    Route::post('doctorLogin',[DoctorController::class,'login']);
    Route::post('/auth/refresh',[SSOController::class,'refreshToken']);

    Route::middleware('auth:api')->group(function() {
        // Doctor routes
            //doctor logout
            Route::post('doctorLogout',[DoctorController::class,'logout']);
            

        // Billing sheet routes
            // upload billing sheet
            Route::post('billingSheetUpload', [BillingSheetController::class, 'billingSheetUpload']); 
            //get uploaded  billing sheet list
            Route::get('billingSheetList', [BillingSheetController::class, 'billingSheetList']);
            // delete billing sheet
            Route::delete('billingSheetDelete/{id}', [BillingSheetController::class, 'billingSheetDelete']);
            // update billing sheet
            Route::post('billingSheetUpdate/{id}', [BillingSheetController::class, 'billingSheetUpdate']);

        // Patient routes
            // hospital list with search
            Route::get('hospitals/{name}', [PatientController::class, 'hostpitalList']);
            //speciality list with search
            Route::get('specialities/{name}', [PatientController::class, 'specialityList']);
            //refer doctor list with search
            Route::get('referDoctor/{name}', [PatientController::class, 'referDoctorList']);
            // add patient
            Route::post('patientAdd', [PatientController::class, 'patientAdd']);
            // get added patients list
            Route::get('patientList', [PatientController::class, 'patientList']);
            // delete patient api
            Route::get('patientDelete/{id}', [PatientController::class, 'patientDelete']);

        // Contact Us
            Route::post('contactUs', [ContactUsController::class, 'contactUs']);         
    });
 });


