<?php

namespace App\Services;

use App\Exceptions\Api\AlreadyExistsException;
use App\Exceptions\Api\UnauthenticatedException;
use App\Http\Resources\Api\AuthResource;
use App\Repositories\UserRepositoryInterface;
use App\Traits\ManageUserTokens;
use App\Traits\WithDbTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService implements AuthServiceInterface
{
    use WithDbTransaction,
        ManageUserTokens;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) { }

    public function login($credentials)
    {
        if (! Auth::attempt($credentials)) {
            throw new UnauthenticatedException;
        }

        $user = $this->userRepository->findByEmailOrFail($credentials['email']);

        $token = $this->createToken($user);

        return new AuthResource(compact('user', 'token'));
    }

    public function register($data)
    {
        $credentials = array_intersect_key($data, array_flip(['email', 'password']));
        if (Auth::attempt($credentials)) {
            throw new AlreadyExistsException;
        }

        $user = $this->withDbTransaction(function () use ($data) {
            return $this->userRepository->create($data);
        });

        $token = $this->createToken($user);

        return new AuthResource(compact('user', 'token'));
    }

}
