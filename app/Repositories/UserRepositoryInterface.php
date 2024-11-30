<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{

    public function findByEmail($email): ?User;
    public function findByEmailOrFail($email): User;

}
