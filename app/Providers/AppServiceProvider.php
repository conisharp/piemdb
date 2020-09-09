<?php

namespace App\Providers;

use App\Repositories\Interfaces\IPieMDBDataSourceRepository;
use App\Repositories\WS\PieMDBJSONDataSourceRepository;
use App\Services\DataSyncService;
use App\Services\Interfaces\IDataSyncService;
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
            IPieMDBDataSourceRepository::class,
            PieMDBJSONDataSourceRepository::class
        );

        $this->app->bind(
            IDataSyncService::class,
            DataSyncService::class
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
