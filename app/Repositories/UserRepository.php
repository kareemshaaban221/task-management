<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function __construct()
    {
        parent::__construct(new User);
    }

    public function findByEmail($email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByEmailOrFail($email): User
    {
        return $this->model->where('email', $email)->firstOrFail();
    }

}
