<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\LogoutRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserResource;
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

    public function attempt(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->validated();
        $this->authService->attempt($credentials);
        return ApiJsonResponse::noContentResponse();
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = $registerRequest->validated();
        $resource = $this->authService->register($data);
        return ApiJsonResponse::successResponse($resource);
    }

    public function logout(LogoutRequest $logoutRequest)
    {
        $user = $logoutRequest->user();
        $this->authService->logout($user);
        return ApiJsonResponse::noContentResponse();
    }

    public function profile(AuthRequest $authRequest)
    {
        $user = $authRequest->user();
        $resource = new UserResource($user);
        return ApiJsonResponse::successResponse($resource);
    }

}
