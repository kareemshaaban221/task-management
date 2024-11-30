<?php

/**
 * This file is responsible for including API route definitions for version 1 of the application related to tasks.
 *
 * The routes defined in this file are used to handle requests related to tasks.
 *
 * @category Routes
 * @package  Routes\v1
 */

use App\Http\Controllers\Api\TaskController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

Route::prefix('tasks')
->name('tasks.')
->group(function () {

    Route::get('test', function () {
        return "Passed!";
    });

    Route::get('model-not-found', function () {
        throw new ModelNotFoundException();
    });

    Route::middleware(['auth:sanctum'])
    ->group(function () {

        Route::resource('/', TaskController::class)->except(['edit', 'create']);

    });

});
