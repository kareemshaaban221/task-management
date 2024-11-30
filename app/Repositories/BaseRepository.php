<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getPaginated($pageSize = 10): Paginator
    {
        return $this->model->paginate($pageSize);
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function findOrFail($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): Model
    {
        $model = $this->findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function updateWhere($id, array $data, array $where): Model
    {
        $model = $this->findOrFail($id);
        $model->where($where)->update($data);
        return $model;
    }

    public function delete($id): bool
    {
        $model = $this->findOrFail($id);
        return $model->delete();
    }

}
