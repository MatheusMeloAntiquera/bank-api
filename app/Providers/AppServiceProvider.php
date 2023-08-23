<?php

namespace App\Providers;

use App\Infra\Services\UserService;
use Illuminate\Support\ServiceProvider;
use App\Domain\User\UserServiceInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infra\Repositories\UserRepositoryQueryBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepositoryQueryBuilder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
