<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{

    public function find($id): ?Model;

    public function findOrFail($id): Model;

    public function create(array $data): Model;

    public function update($id, array $data): Model;

    public function delete($id): bool;

}
