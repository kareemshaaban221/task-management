<?php

namespace App\Services;

interface AuthServiceInterface
{

    public function login($credentials);

    public function attempt($credentials);

    public function register($data);

    public function logout($user);

}
