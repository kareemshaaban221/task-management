<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{

    public function getForUserPaginated($userId, $pageSize = 10): Paginator
    {
        return $this->model->where('user_id', $userId)->latest('due_date')->paginate($pageSize);
    }

    public function getForUser($userId): Collection
    {
        return $this->model->where('user_id', $userId)->latest('due_date')->get();
    }

    public function createForUser($userId, array $data): Task
    {
        $data['user_id'] = $userId;
        return $this->create($data);
    }

}
