<?php

/**
 * This file is responsible for including API route definitions for the application.
 *
 * It imports the routes from the versioned API files to maintain modularity and organization
 * of the route definitions.
 *
 * @category Routes
 * @package  Routes
 */

use Illuminate\Support\Facades\Route;

Route::name('api.')
->group(function () {

    require_once __DIR__.'/v1/api.php';

    // >>> add new versions

});
