<?php

namespace App\Services;

use App\Enums\TaskStatusEnum;
use App\Http\Resources\Api\PaginationResource;
use App\Http\Resources\Api\TaskResource;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Traits\WithDbTransaction;
use Illuminate\Support\Carbon;

class TaskService implements TaskServiceInterface
{
    use WithDbTransaction;

    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly UserRepositoryInterface $userRepository,
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

    public function getUserTaskById($userId, $taskId)
    {
        $task = $this->taskRepository->findOrFailForUser($userId, $taskId);
        return new TaskResource($task);
    }

    public function createUserTask($userId, $data)
    {
        $data = $this->updateStatusBasedOnDueDate($data);

        $task = $this->withDbTransaction(function () use ($userId, $data) {
            return $this->taskRepository->createForUser($userId, $data);
        });

        return new TaskResource($task);
    }

    public function assignUserTask($userEmail, $data)
    {
        $user = $this->userRepository->findByEmailOrFail($userEmail);
        return $this->createUserTask($user->id, $data);
    }

    public function updateUserTask($userId, $taskId, $data)
    {
        if (array_key_exists('due_date', $data)) {
            $data = $this->updateStatusBasedOnDueDate($data);
        }

        $task = $this->withDbTransaction(function () use ($userId, $taskId, $data) {
            return $this->taskRepository->updateForUser($userId, $taskId, $data);
        });

        return new TaskResource($task);
    }

    public function deleteUserTask($userId, $taskId)
    {
        return $this->taskRepository
            ->findOrFailForUser($userId, $taskId)
            ->delete();
    }

    private function updateStatusBasedOnDueDate($data)
    {
        $data['due_date'] = Carbon::parse($data['due_date']);
        if ($data['due_date']->lessThanOrEqualTo(now())) {
            $data['status'] = TaskStatusEnum::OVER_DUE();
        }
        return $data;
    }

}
