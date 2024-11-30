<?php

namespace App\Services;

interface AuthServiceInterface
{

    public function login($credentials);

    public function register($data);

}
