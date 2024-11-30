<?php

namespace App\Services;

interface TaskServiceInterface
{

    public function getUserTasks($userId, $paginated = 0);

    public function getUserTaskById($userId, $taskId);

    public function createUserTask($userId, $data);

    public function assignUserTask($userEmail, $data);

    public function updateUserTask($userId, $taskId, $data);

    public function deleteUserTask($userId, $taskId);

}
