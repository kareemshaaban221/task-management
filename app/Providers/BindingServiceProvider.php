<?php

namespace App\Providers;

use App\Classes\Api\ApiResponse;
use App\Classes\Api\ApiResponseInterface;
use App\Models\Task;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\AuthService;
use App\Services\AuthServiceInterface;
use App\Services\TaskService;
use App\Services\TaskServiceInterface;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerClasses();
        $this->registerRepositories();
        $this->registerServices();
    }

    public function registerClasses()
    {
        $this->app->singleton(ApiResponseInterface::class, ApiResponse::class);
    }

    public function registerRepositories()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, fn () => resolve(UserRepository::class, ['model' => new User()]));
        $this->app->bind(TaskRepositoryInterface::class, fn () => resolve(TaskRepository::class, ['model' => new Task()]));
    }

    public function registerServices()
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
    }
}
