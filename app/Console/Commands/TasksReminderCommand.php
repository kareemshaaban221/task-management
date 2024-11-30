<?php

namespace App\Console\Commands;

use App\Notifications\TaskReminderNotification;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Console\Command;

class TasksReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for tasks that are overdue or nearing their due date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var UserRepositoryInterface */
        $repo = app()->make(UserRepositoryInterface::class);
        $repo->getAll()->map(function ($user) {
            $this->info($user->name);
            $user->notify(new TaskReminderNotification(now()->addYear()));
        });
    }
}
