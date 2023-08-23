<?php

namespace App\Providers;

use App\Infra\Services\UserService;
use App\Infra\Services\StoreService;
use Illuminate\Support\ServiceProvider;
use App\Domain\User\UserServiceInterface;
use App\Domain\Store\StoreServiceInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\Store\StoreRepositoryInterface;
use App\Infra\Repositories\StoreRepositoryEloquent;
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

        $this->app->bind(StoreServiceInterface::class, StoreService::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
