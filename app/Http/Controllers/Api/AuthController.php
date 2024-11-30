<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\AuthServiceInterface;

class AuthController extends Controller
{

    public function __construct(
        private readonly AuthServiceInterface $authService
    ) { }

    public function login(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->validated();
        $resource = $this->authService->login($credentials);
        return ApiJsonResponse::successResponse($resource);
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = $registerRequest->validated();
        $resource = $this->authService->register($data);
        return ApiJsonResponse::successResponse($resource);
    }

}
