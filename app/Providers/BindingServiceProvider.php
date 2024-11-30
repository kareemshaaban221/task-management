<?php

namespace App\Providers;

use App\Classes\Api\ApiResponse;
use App\Classes\Api\ApiResponseInterface;
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
        //
    }

    public function registerServices()
    {
        //
    }
}
