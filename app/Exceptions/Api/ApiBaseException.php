<?php

/**
 * This file contains the ApiBaseException class used within the application.
 *
 * The ApiBaseException class is a base class for all API related exceptions. It
 * extends the Exception class and is responsible for managing the exception
 * message and errors array.
 *
 * @category Exceptions
 * @package  App\Exceptions\Api
 * @author   Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Exceptions\Api;

use App\Facades\ApiJsonResponse;
use Exception;

class ApiBaseException extends Exception
{

    protected $errors;

    public function __construct($message = "Api Exception", $errors = null)
    {
        parent::__construct($message);
        $this->errors = $errors;
    }

    public function render()
    {
        return ApiJsonResponse::serverErrorResponse(
            $errors ?? $this->getTrace(),
            $this->getCode(),
            $this->getMessage()
        );
    }

}
