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

class ApiResponse
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
        $this->data = $data;
        $this->message = $message;
        $this->status = true;
        $this->code = $code;
        return response()->json(self::build($this), $code);
    }

    public function clientErrorResponse($errors, $code = 400, $message = "Error")
    {
        $this->errors = $errors;
        $this->message = $message;
        $this->status = false;
        $this->code = $code;
        return response()->json(self::build($this), $code);
    }

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

    // ----------------------------------
    // Client Error Methods
    // ----------------------------------
    public function notFoundResponse($data = [], $message = "Not Found")
    {
        return $this->clientErrorResponse($data, Response::HTTP_NOT_FOUND, $message);
    }

}