<?php

namespace App\Exceptions;

use App\Exceptions\Api\UnauthenticatedException;
use App\Facades\ApiJsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{

    public static function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            if (
                $exception instanceof ModelNotFoundException ||
                $exception instanceof NotFoundHttpException
            ) {
                return ApiJsonResponse::notFoundResponse([
                    [
                        'type' => $exception::class,
                        'message' => $exception->getMessage(),
                    ]
                ]);
            }

            if ($exception instanceof ValidationException) {
                return ApiJsonResponse::validationErrorResponse($exception->errors());
            }

            if ($exception instanceof AuthenticationException) {
                throw new UnauthenticatedException;
            }
        }
    }

}
