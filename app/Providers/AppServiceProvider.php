<?php

namespace App\Providers;

use App\Infra\Services\UserService;
use App\Infra\Services\StoreService;
use App\Infra\Services\PurchaseService;
use App\Infra\Services\TransferService;
use Illuminate\Support\ServiceProvider;
use App\Domain\User\UserServiceInterface;
use App\Domain\Store\StoreServiceInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TransferController;
use App\Domain\Store\StoreRepositoryInterface;
use App\Infra\Repositories\StoreRepositoryEloquent;
use App\Infra\Repositories\UserRepositoryQueryBuilder;
use App\Domain\Transaction\TransactionServiceInterface;
use App\Domain\Transaction\TransactionRepositoryInterface;
use App\Infra\Repositories\PurchaseRepositoryQueryBuilder;
use App\Infra\Repositories\TransferRepositoryQueryBuilder;

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

        $this->app->when(TransferController::class)->needs(TransactionServiceInterface::class)->give(TransferService::class);
        $this->app->when(TransferController::class)->needs(TransactionRepositoryInterface::class)->give(TransferRepositoryQueryBuilder::class);
        $this->app->when(TransferService::class)->needs(TransactionRepositoryInterface::class)->give(TransferRepositoryQueryBuilder::class);

        $this->app->when(PurchaseController::class)->needs(TransactionServiceInterface::class)->give(PurchaseService::class);
        $this->app->when(PurchaseController::class)->needs(TransactionRepositoryInterface::class)->give(PurchaseRepositoryQueryBuilder::class);
        $this->app->when(PurchaseService::class)->needs(TransactionRepositoryInterface::class)->give(PurchaseRepositoryQueryBuilder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
