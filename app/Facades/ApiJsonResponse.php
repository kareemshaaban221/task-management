<?php

/**
 * This file defines the ApiJsonResponse facade used within the application.
 *
 * The ApiJsonResponse facade provides a convenient interface for sending JSON
 * responses from the application, using the ApiResponseInterface. It is
 * responsible for accepting the ApiResponseInterface object and returning
 * the JSON response.
 *
 * @category Facades
 * @package  App\Facades
 * @author   Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Facades;

use App\Classes\Api\ApiResponseInterface;
use Illuminate\Support\Facades\Facade;

class ApiJsonResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ApiResponseInterface::class;
    }
}
