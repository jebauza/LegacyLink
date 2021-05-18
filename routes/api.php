<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CandleApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\CeremonyApiController;
use App\Http\Controllers\Api\AssistanceApiController;
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

// Public
Route::prefix('public')->name('api.public.')->group(function () {
    Route::get('profile/{web_code}', [DeceasedProfileApiController::class, 'show'])->name('profile.show');

    Route::prefix('profile/{profile_id}')->middleware(['check_profile'])->group(function () {

        Route::get('ceremonies', [CeremonyApiController::class, 'indexPublic'])->name('ceremonies.index');

        Route::prefix('comments')->name('comments.')->group(function () {
            Route::get('/', [CommentApiController::class, 'indexPublic'])->name('index');
            Route::post('store', [CommentApiController::class, 'storePublic'])->name('store');
        });

        // Candles
        Route::prefix('candles')->name('candles.')->group(function () {
            Route::get('/', [CandleApiController::class, 'indexPublic'])->name('indexPublic');
            Route::post('store', [CandleApiController::class, 'storePublic'])->name('storePublic');
            // Route::post('store', [InvitationApiController::class, 'store'])->name('store');
        });
    });
});

Route::middleware(['auth:api','verified'])->name('api.')->group(function() {

    // AUTHENTICATION
    Route::prefix('auth')->name('auth.')->group(function () {

        Route::post('login', [AuthApiController::class, 'login'])->name('login')->withoutMiddleware(['auth:api','verified']);
        Route::get('login/declarant', [AuthApiController::class, 'loginProfile'])->name('login.profile')->withoutMiddleware(['auth:api','verified']);
        Route::post('register', [AuthApiController::class, 'register'])->name('register')->withoutMiddleware(['auth:api','verified']);
        Route::post('verification-email/send', [AuthApiController::class, 'verificationEmailSend'])->name('verification.email.send')->withoutMiddleware(['auth:api','verified']);
        Route::post('forget-password/send', [AuthApiController::class, 'forgetPassword'])->name('forget-password')->withoutMiddleware(['auth:api','verified']);
        Route::post('reset-password', [AuthApiController::class, 'updatePassword'])->name('reset-password')->withoutMiddleware(['auth:api','verified']);

        Route::get('logout', [AuthApiController::class, 'logout'])->name('logout');
        Route::get('user/{profile_id?}', [AuthApiController::class, 'user'])->name('user');
        Route::post('profile/join', [AuthApiController::class, 'profileJoin'])->name('join.profile');
    });

    Route::prefix('profile/{profile_id}')->middleware(['check_profile','check_role'])->group(function () {

        // Profile
        Route::name('profile.')->middleware(['check_role:admin'])->group(function () {
            Route::post('update', [DeceasedProfileApiController::class, 'update'])->name('update');
        });

        // Clients
        Route::prefix('clients')->middleware(['check_role:admin'])->name('clients.')->group(function () {
            Route::get('', [UserApiController::class, 'index'])->name('index');
            Route::delete('/{client_id}/detach', [UserApiController::class, 'detach'])->name('detach');
        });

        // Ceremonies
        Route::prefix('ceremonies')->name('ceremonies.')->group(function () {
            Route::get('', [CeremonyApiController::class, 'index'])->name('index');

            Route::middleware(['check_role:admin'])->group(function () {
                Route::get('ceremony-types', [CeremonyApiController::class, 'getCeremonyTypes'])->name('getCeremonyTypes');
                Route::post('store', [CeremonyApiController::class, 'store'])->name('store');
                Route::put('/{ceremony_id}/update', [CeremonyApiController::class, 'update'])->name('update');
                Route::delete('/{ceremony_id}/destroy', [CeremonyApiController::class, 'destroy'])->name('destroy');
            });

            Route::get('/{ceremony_id}/assistance', [AssistanceApiController::class, 'index'])->name('assistance.index');
            Route::put('/{ceremony_id}/assistance/update', [AssistanceApiController::class, 'update'])->name('assistance.update');
        });

        // Invitations
        Route::prefix('invitations')->middleware(['check_role:admin'])->name('invitations.')->group(function () {
            Route::get('', [InvitationApiController::class, 'index'])->name('index');
            Route::post('store', [InvitationApiController::class, 'store'])->name('store');
            Route::delete('/{invitation_id}/destroy', [InvitationApiController::class, 'destroy'])->name('destroy');
        });

        // Comments
        Route::prefix('comments')->name('comments.')->middleware(['check_role:admin,family,close_friend'])->group(function () {
            Route::get('/', [CommentApiController::class, 'index'])->name('index');
            Route::get('/private', [CommentApiController::class, 'indexPrivate'])->name('indexPrivate');
            Route::post('store', [CommentApiController::class, 'store'])->name('store');
            Route::post('/{comment_id}/update', [CommentApiController::class, 'update'])->name('update');
            Route::delete('/{comment_id}/destroy', [CommentApiController::class, 'destroy'])->name('destroy');
            Route::put('/{comment_id}/approve', [CommentApiController::class, 'approve'])->name('approve');
        });


        // Candles
        Route::prefix('candles')->name('candles.')->middleware(['check_role:admin'])->group(function () {
            Route::delete('/{candle_id}/destroy', [CandleApiController::class, 'destroy'])->name('destroy');
        });

    });

});



