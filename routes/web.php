<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\User\AuthController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::prefix('users')->name('web.users.')->group(function () {
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerify'])->middleware(['signed'])->name('email.verify');
    Route::get('/reset-password', [AuthController::class, 'getResetPassword']);
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('reset.password');
});

Route::get('/', function () {
    //return redirect()->route('login');
    // return view('welcome');
    return redirect()->away('https://celebrasuvida.es/');
});
