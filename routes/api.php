<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CeremonyApiController;
use App\Http\Controllers\Api\CommentaryApiController;
use App\Http\Controllers\Api\InvitationApiController;
use App\Http\Controllers\Api\DeceasedProfileApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('public')->middleware(['check_profile'])->group(function () {
    Route::get('profile/{profile_id}', [DeceasedProfileApiController::class, 'show'])->name('api.public.profile.show');
    Route::get('profile/{profile_id}/ceremonies', [CeremonyApiController::class, 'indexPublic'])->name('api.public.profile.ceremonies');
    Route::get('profile/{profile_id}/comments/store', [CommentaryApiController::class, 'storePublic'])->name('api.public.profile.ceremonies');
});


Route::middleware(['auth:api'])->name('api.')->group(function() {

    // AUTHENTICATION
    Route::prefix('auth')->name('auth.')->group(function () {
        // Route::post('register', [UserAuthController::class, 'register'])->name('register')->withoutMiddleware(['auth:api']);
        Route::post('login', [AuthApiController::class, 'login'])->name('login')->withoutMiddleware(['auth:api']);
        Route::get('login/declarant', [AuthApiController::class, 'loginProfile'])->name('login.profile')->withoutMiddleware(['auth:api']);
        Route::post('register', [AuthApiController::class, 'register'])->name('register')->withoutMiddleware(['auth:api']);

        Route::get('logout', [AuthApiController::class, 'logout'])->name('logout');
        Route::get('user/{profile_id}', [AuthApiController::class, 'user'])->name('user')->middleware(['check_profile']);
        Route::post('profile/join', [AuthApiController::class, 'profileJoin'])->name('join.profile');
    });

    Route::prefix('profile/{profile_id}')->middleware(['check_profile'])->group(function () {

        Route::name('profile.')->middleware(['check_role:admin'])->group(function () {
            Route::put('update', [DeceasedProfileApiController::class, 'update'])->name('update');
        });

        Route::prefix('clients')->middleware(['check_role:admin'])->name('clients.')->group(function () {
            Route::get('', [UserApiController::class, 'index'])->name('index');
            Route::delete('/{client_id}/detach', [UserApiController::class, 'detach'])->name('detach');
        });

        Route::prefix('ceremonies')->middleware(['check_role:admin'])->name('ceremonies.')->group(function () {
            Route::get('', [CeremonyApiController::class, 'index'])->name('index');
            Route::get('ceremony-types', [CeremonyApiController::class, 'getCeremonyTypes'])->name('getCeremonyTypes');
            Route::post('store', [CeremonyApiController::class, 'store'])->name('store');
            Route::put('/{ceremony_id}/update', [CeremonyApiController::class, 'update'])->name('update');
            Route::delete('/{ceremony_id}/destroy', [CeremonyApiController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('invitations')->middleware(['check_role:admin'])->name('invitations.')->group(function () {
            Route::get('', [InvitationApiController::class, 'index'])->name('index');
            Route::post('store', [InvitationApiController::class, 'store'])->name('store');
        });



    });

});



