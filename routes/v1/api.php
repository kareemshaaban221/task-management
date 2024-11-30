<?php

/**
 * This file is responsible for including API route definitions for version 1 of the application.
 *
 * The routes defined in the included files are used to handle requests related to users and tasks.
 * It imports the routes from separate files, `api.users.php` and `api.tasks.php`, to maintain
 * modularity and organization of the route definitions.
 *
 * @category Routes
 * @package  Routes\v1
 */

use Illuminate\Support\Facades\Route;

Route::prefix('v1')
->name('v1.')
->group(function () {

    require_once __DIR__ . '/api.users.php';
    require_once __DIR__ . '/api.tasks.php';

});
