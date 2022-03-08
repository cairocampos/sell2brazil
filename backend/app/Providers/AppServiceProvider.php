<?php

namespace App\Providers;

use App\Jobs\SyncServer;
use App\Services\Notifiers\ApiNotifier;
use App\Services\Notifiers\INotifier;
use App\Services\Notifiers\WebApiNotifier;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Interfaces\IOrderRepository::class,
            \App\Repositories\OrderRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
