<?php

namespace App\Services;

use App\Enums\TaskStatusEnum;
use App\Http\Resources\Api\PaginationResource;
use App\Http\Resources\Api\TaskResource;
use App\Repositories\TaskRepositoryInterface;
use App\Traits\WithDbTransaction;
use Illuminate\Support\Carbon;

class TaskService implements TaskServiceInterface
{
    use WithDbTransaction;

    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    ) { }

    public function getUserTasks($userId, $paginated = 0)
    {
        if ($paginated > 0) {
            $paginator = $this->taskRepository->getForUserPaginated($userId, $paginated);
            return new PaginationResource($paginator, TaskResource::class);
        }
        $tasks = $this->taskRepository->getForUser($userId);
        return TaskResource::collection($tasks);
    }

    public function createUserTask($userId, $data)
    {
        $data['due_date'] = Carbon::parse($data['due_date']);
        if ($data['due_date']->lessThanOrEqualTo(now())) {
            $data['status'] = TaskStatusEnum::OVER_DUE();
        }

        $task = $this->withDbTransaction(function () use ($userId, $data) {
            return $this->taskRepository->createForUser($userId, $data);
        });

        return new TaskResource($task->fresh());
    }

}
