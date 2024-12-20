<?php

/**
 * This file defines the ApiResponseInterface used within the application.
 *
 * The ApiResponseInterface outlines the methods required for implementing
 * an API response handler. It provides a contract for building various
 * types of HTTP responses, such as success, error, paginated, and not found
 * responses. This interface ensures consistency and standardization across
 * different implementations of API responses in the application.
 *
 * @category Interfaces
 * @package  App\Classes\Api
 * @author   Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Classes\Api;

use App\Http\Resources\Api\PaginationResource;

interface ApiResponseInterface
{

    public function successResponse($data, $code = 200, $message = "Success");
    public function clientErrorResponse($errors, $code = 400, $message = "Error");
    public function serverErrorResponse($errors, $code = 500, $message = "Error");
    public function okResponse($data, $message = "Success");
    public function paginatedResponse(PaginationResource $resource, $code = 200, $message = "Success");
    public function createdResponse($data, $message = "Created");
    public function noContentResponse($message = "No Content");
    public function notFoundResponse($errors = [], $message = "Not Found");
    public function validationErrorResponse($errors = [], $message = "Validation Error");

}
