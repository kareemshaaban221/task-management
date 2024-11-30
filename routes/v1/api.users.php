<?php

/**
 * This file is responsible for including API route definitions for version 1 of the application related to users.
 *
 * The routes defined in this file are used to handle requests related to user management, such as
 * creating, updating, and deleting user accounts, as well as fetching user information.
 *
 * @category Routes
 * @package  Routes\v1
 */

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

Route::prefix('users')
->name('users.')
->group(function () {

    Route::get('test', function () {
        return "Passed!";
    });

    Route::get('model-not-found', function () {
        throw new ModelNotFoundException();
    });

});
