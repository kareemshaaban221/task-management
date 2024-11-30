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
use Symfony\Component\HttpFoundation\Response;

class UnauthenticatedException extends Exception
{

    protected $errors;

    public function __construct($message = "Unauthenticated", $errors = null)
    {
        parent::__construct($message);
        $this->errors = $errors;
    }

    public function render()
    {
        return ApiJsonResponse::clientErrorResponse(
            [
                'type' => 'auth_error',
                'message' => 'Check your credentials',
            ],
            Response::HTTP_UNAUTHORIZED,
            $this->getMessage()
        );
    }

}
