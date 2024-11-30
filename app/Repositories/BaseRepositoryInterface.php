<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{

    public function getPaginated($pageSize = 10): Paginator;

    public function getAll(): Collection;

    public function find($id): ?Model;

    public function findOrFail($id): Model;

    public function create(array $data): Model;

    public function update($id, array $data): Model;

    public function delete($id): bool;

}
