<?php

/**
 * API routes for user management.
 *
 * Routes defined in this file are used to handle requests related to user management, such as
 * creating, updating, and deleting user accounts, as well as fetching user information.
 *
 * @category Routes
 * @package  Routes\v1
 */

use App\Http\Controllers\Api\AuthController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
->name('auth.')
->group(function () {

    Route::get('test', function () {
        return "Passed!";
    });

    Route::get('model-not-found', function () {
        throw new ModelNotFoundException();
    });

    Route::middleware(['guest'])
    ->group(function () {

        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('attempt', [AuthController::class, 'attempt'])->name('attempt');
        Route::post('register', [AuthController::class, 'register'])->name('register');

    });

    Route::middleware(['auth:sanctum'])
    ->group(function () {

        Route::get('profile', [AuthController::class, 'profile'])->name('profile');

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    });

});
