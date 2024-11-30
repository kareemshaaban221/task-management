<?php

namespace App\Observers;

use App\Enums\TaskStatusEnum;
use App\Models\Task;

class TaskObserver
{

    public function retrieved(Task $task)
    {
        if ($task->due_date->lessThanOrEqualTo(now()) && $task->status !== TaskStatusEnum::OVER_DUE()) {
            $task->status = TaskStatusEnum::OVER_DUE();
            $task->save();
            $task->refresh();
        }
    }

}
