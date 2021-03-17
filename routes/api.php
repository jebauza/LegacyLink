<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::middleware(['auth:api'])->name('api.')->group(function() {

    // AUTHENTICATION
    Route::prefix('auth')->name('auth.')->group(function () {
        // Route::post('register', [UserAuthController::class, 'register'])->name('register')->withoutMiddleware(['auth:api']);
        Route::post('login', [AuthApiController::class, 'login'])->name('login')->withoutMiddleware(['auth:api']);

        Route::get('logout', [AuthApiController::class, 'logout'])->name('logout');
        Route::get('user', [AuthApiController::class, 'user'])->name('user');
    });

});
Route::get('public/profile/{profile_id}', [DeceasedProfileApiController::class, 'byId'])->name('api.profile.byId');
