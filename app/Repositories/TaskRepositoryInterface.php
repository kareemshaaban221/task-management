<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface extends BaseRepositoryInterface
{

    public function getForUserPaginated($userId, $pageSize = 10): Paginator;

    public function getForUser($userId): Collection;

    public function createForUser($userId, array $data): Task;

}
