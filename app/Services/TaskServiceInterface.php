<?php

namespace App\Services;

interface TaskServiceInterface
{

    public function getUserTasks($userId, $paginated = 0);

    public function createUserTask($userId, $data);

}
