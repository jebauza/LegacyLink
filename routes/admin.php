<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Office\OfficeController;
use App\Http\Controllers\Admin\Ceremony\CeremonyController;
use App\Http\Controllers\Admin\Employee\EmployeeController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Ceremony\StreamingController;
use App\Http\Controllers\Admin\Province\ProvincesController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\CeremonyType\CeremonyTypeController;
use App\Http\Controllers\Admin\DeceasedProfile\DeceasedProfileController;

Route::name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.home');
    })->name('path');

    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::get('login', [LoginController::class, 'login']);
    Route::post('login', [LoginController::class, 'authenticate'])->name('login');

    Route::get('forget-password', [ForgotPasswordController::class, 'getEmail']);
    Route::post('forget-password', [ForgotPasswordController::class, 'postEmail'])->name('forget-password');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'getPassword']);
    Route::post('reset-password', [ResetPasswordController::class, 'updatePassword'])->name('reset-password');

    Route::middleware('auth')->group(function () {

        Route::get('home', [HomeController::class, 'home'])->name('home');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('offices', [OfficeController::class, 'indexView'])->name('offices.indexView')->middleware('permission:offices.view');
        Route::get('employees', [EmployeeController::class, 'indexView'])->name('employees.indexView');
        Route::get('webs', [DeceasedProfileController::class, 'indexView'])->name('webs.indexView');
        Route::get('streaming', [StreamingController::class, 'indexView'])->name('streaming.indexView');
        // Route::get('webs/{profile_id}/show', [DeceasedProfileController::class, 'showView'])->name('webs.show.view');
        Route::get('clients', [UserController::class, 'indexView'])->name('clients.indexView');
        // Route::get('emails', [MailController::class, 'index']);

        Route::prefix('ajax')->name('ajax.')->middleware('ajax')->group(function () {

            // Office
            Route::prefix('offices')->name('offices.')->group(function () {

                Route::get('/', [OfficeController::class, 'index'])->name('index');
                Route::get('/paginate', [OfficeController::class, 'paginate'])->name('paginate');
                Route::post('store', [OfficeController::class, 'store'])->name('store')->middleware('permission:offices.store');
                Route::get('show', [OfficeController::class, 'show'])->name('show');
                Route::put('/{office_id}/update', [OfficeController::class, 'update'])->name('update')->middleware('permission:offices.store');
                Route::delete('/{office_id}/destroy', [OfficeController::class, 'destroy'])->name('destroy');
            });

            // Employee
            Route::prefix('employees')->name('employees.')->group(function () {

                Route::get('/', [EmployeeController::class, 'index'])->name('index');
                Route::get('/paginate', [EmployeeController::class, 'paginate'])->name('paginate');
                Route::post('store', [EmployeeController::class, 'store'])->name('store');
                Route::get('show', [EmployeeController::class, 'show'])->name('show');
                Route::put('/{employee_id}/update', [EmployeeController::class, 'update'])->name('update');
                Route::delete('/{employee_id}/destroy', [EmployeeController::class, 'destroy'])->name('destroy');

            });

            // Webs
            Route::prefix('webs')->name('webs.')->group(function () {

                Route::get('/', [DeceasedProfileController::class, 'index'])->name('index');
                Route::get('/{profile_id}/send-notification', [DeceasedProfileController::class, 'sendNotification'])->name('sendNotification');
                Route::get('/paginate', [DeceasedProfileController::class, 'paginate'])->name('paginate');
                Route::post('store', [DeceasedProfileController::class, 'store'])->name('store');
                Route::delete('/{profile_id}/destroy', [DeceasedProfileController::class, 'destroy'])->name('destroy');
                Route::put('/{profile_id}/update', [DeceasedProfileController::class, 'update'])->name('update');
                Route::put('/{profile_id}/update/declarant', [DeceasedProfileController::class, 'updateDeclarant'])->name('updateDeclarant');
                /* Route::get('show', [DeceasedProfileController::class, 'show'])->name('show');
                Route::put('/{employee_id}/update', [DeceasedProfileController::class, 'update'])->name('update');
                 */

            });

             // Streaming
             Route::prefix('streaming')->name('streaming.')->group(function () {
                Route::get('/paginate', [StreamingController::class, 'paginate'])->name('paginate');
                Route::post('/{ceremony_id}/save', [StreamingController::class, 'save'])->name('save');
            });

            // Users
            Route::prefix('clients')->name('clients.')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/paginate', [UserController::class, 'paginate'])->name('paginate');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::put('/{client_id}/update', [UserController::class, 'update'])->name('update');
                Route::put('/{client_id}/status', [UserController::class, 'changeStatus'])->name('status');
                Route::delete('/{client_id}/destroy', [UserController::class, 'destroy'])->name('destroy');
                Route::put('/{client_id}/restore', [UserController::class, 'restore'])->name('destroy.restore');
                Route::delete('/{client_id}/destroy/force-delete', [UserController::class, 'forceDelete'])->name('destroy.force-delete');
                Route::get('/{client_id}/send/verification-mail', [UserController::class, 'sendVerificationMail'])->name('send.verification-mail');
            });

            // Ceremonies
            Route::prefix('ceremonies')->name('ceremonies.')->group(function () {

                Route::get('/', [CeremonyController::class, 'index'])->name('index');
                Route::post('/store', [CeremonyController::class, 'store'])->name('store');
                Route::put('/{ceremony_id}/update', [CeremonyController::class, 'update'])->name('update');
                Route::delete('/{ceremony_id}/destroy', [CeremonyController::class, 'destroy'])->name('destroy');
                Route::get('/{ceremony_id}/show', [CeremonyController::class, 'show'])->name('show');
            });

            Route::get('/roles', [RoleController::class, 'getRolesByAuthUserAssign'])->name('roles.ByAuthUserAssign');
            Route::get('/ceremony_types', [CeremonyTypeController::class, 'index'])->name('ceremony_types.index');
            Route::get('/provinces', [ProvincesController::class, 'index'])->name('provinces.index');

        });

    });

});
