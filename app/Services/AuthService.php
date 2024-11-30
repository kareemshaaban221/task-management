<?php

namespace App\Services;

use App\Exceptions\Api\UnauthenticatedException;
use App\Http\Resources\Api\AuthResource;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) { }

    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = $this->userRepository->findByEmailOrFail($credentials['email']);
            $user->tokens()->delete();
            $token = $user->createToken(
                $user->getAuthTokenName(),
                ['*'],
                $user->getAuthTokenExpectedExpirationDate()
            );
            return new AuthResource(compact('user', 'token'));
        } else {
            throw new UnauthenticatedException;
        }
    }
}
