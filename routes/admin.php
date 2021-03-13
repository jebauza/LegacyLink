<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;


Route::name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.home');
    })->name('path');

    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::get('login', [LoginController::class, 'login']);
    Route::post('login', [LoginController::class, 'authenticate'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('forget-password', [ForgotPasswordController::class, 'getEmail']);
    Route::post('forget-password', [ForgotPasswordController::class, 'postEmail'])->name('forget-password');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'getPassword']);
    Route::post('reset-password', [ResetPasswordController::class, 'updatePassword'])->name('reset-password');

    Route::get('home', [HomeController::class, 'home'])->name('home');

    Route::middleware('auth')->group(function () {



    });

});
