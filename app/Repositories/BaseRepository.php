<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
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
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id): bool
    {
        $model = $this->find($id);
        return $model->delete();
    }

}
