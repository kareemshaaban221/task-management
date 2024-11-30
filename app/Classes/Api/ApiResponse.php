<?php

/**
 * This file defines the ApiResponse class used within the application.
 *
 * The ApiResponse class implements the ApiResponseInterface and provides
 * functionality to handle the response of the application. It is responsible
 * for creating and returning JSON responses.
 *
 * @category Classes
 * @package  App\Classes\Api
 * @author   Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Classes\Api;

use App\Http\Resources\Api\PaginationResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse implements ApiResponseInterface
{

    protected $status;
    protected $code;
    protected $message = '';
    protected $data = [];
    protected $errors = [];
    protected $pagination_details = null;

    // ----------------------------------
    // Static Methods
    // ----------------------------------
    /**
     * Builds the API response by taking an ApiResponse object and
     * returns the response array.
     *
     * @param ApiResponse $apiResponseObject
     * @return array
     */
    public static function build(self $apiResponseObject) {
        $response = [
            'status'    => $apiResponseObject->status,
            'code'      => $apiResponseObject->code,
            'message'   => $apiResponseObject->message,
        ];

        if ($apiResponseObject->status) {
            $response['data'] = $apiResponseObject->data;
            if ($apiResponseObject->pagination_details) {
                $response['pagination_details'] = $apiResponseObject->pagination_details;
            }
        } else {
            $response['errors'] = $apiResponseObject->errors;
        }

        return $response;
    }

    // ----------------------------------
    // Instance Methods
    // ----------------------------------
    /**
     * Build a success API response.
     *
     * @param mixed $data Data to be returned in the response.
     * @param int $code HTTP status code.
     * @return JsonResponse|mixed
     */
    public function successResponse($data, $code = 200, $message = "Success")
    {
        if ($data instanceof PaginationResource) {
            return $this->paginatedResponse($data, $code, $message);
        }

        $this->data = $data;
        $this->message = $message;
        $this->status = true;
        $this->code = $code;
        return response()->json(self::build($this), $code);
    }

    /**
     * Build a client error (4xx) API response.
     *
     * @param array $errors Validation errors or any other error messages.
     * @param int $code HTTP status code.
     * @return JsonResponse|mixed
     */
    public function clientErrorResponse($errors, $code = 400, $message = "Error")
    {
        $this->errors = $errors;
        $this->message = $message;
        $this->status = false;
        $this->code = $code;
        return response()->json(self::build($this), $code);
    }

    /**
     * Build a server error (5xx) API response.
     *
     * @param array $errors Error messages or details.
     * @param int $code HTTP status code, defaults to 500.
     * @param string $message Error message, defaults to "Error".
     * @return JsonResponse|mixed
     */
    public function serverErrorResponse($errors, $code = 500, $message = "Error")
    {
        $this->errors = $errors;
        $this->message = $message;
        $this->status = false;
        $this->code = $code;
        return response()->json(self::build($this), $code);
    }

    // ----------------------------------
    // Success Methods
    // ----------------------------------
    /**
     * Build an HTTP 200 OK success response.
     *
     * @param mixed $data Data to be returned in the response.
     * @return JsonResponse|mixed
     */
    public function okResponse($data, $message = "Success")
    {
        return $this->successResponse($data, Response::HTTP_OK, $message);
    }

    /**
     * Build a paginated API response.
     *
     * @param PaginationResource $resource
     * @param int $code
     * @return JsonResponse|mixed
     */
    public function paginatedResponse(PaginationResource $resource, $code = 200, $message = "Success")
    {
        $this->data = $resource->getData();
        $this->code = $code;
        $this->pagination_details = $resource->getPaginationDetails();
        return $this->successResponse($this->data, $code, $message);
    }

    /**
     * Build an HTTP 201 Created success response.
     *
     * @param mixed $data Data to be returned in the response.
     * @return JsonResponse|mixed
     */
    public function createdResponse($data, $message = "Created")
    {
        return $this->successResponse($data, Response::HTTP_CREATED, $message);
    }

    /**
     * Build an HTTP 204 No Content success response.
     *
     * @param string $message Success message.
     * @return JsonResponse|mixed
     */
    public function noContentResponse($message = "No Content")
    {
        return $this->successResponse(null, Response::HTTP_NO_CONTENT, $message);
    }

    // ----------------------------------
    // Client Error Methods
    // ----------------------------------
    /**
     * Build an HTTP 404 Not Found client error response.
     *
     * @param array $errors Errors to be returned in the response.
     * @param string $message Error message to be returned in the response.
     * @return JsonResponse|mixed
     */
    public function notFoundResponse($errors = [], $message = "Not Found")
    {
        return $this->clientErrorResponse($errors, Response::HTTP_NOT_FOUND, $message);
    }

    /**
     * Build an HTTP 422 Unprocessable Entity client error response, typically used
     * for validation errors.
     *
     * @param array $errors Errors to be returned in the response.
     * @param string $message Error message to be returned in the response.
     * @return JsonResponse|mixed
     */
    public function validationErrorResponse($errors = [], $message = "Validation Error")
    {
        return $this->clientErrorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }

}
