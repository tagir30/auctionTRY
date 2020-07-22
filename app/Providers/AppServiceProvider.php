<?php

namespace App\Providers;

use App\Jobs\ProcessLotCancel;
use App\Lot;
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
        $this->app->bindMethod(ProcessLotCancel::class . '@handle', function ($job, $app) {
            return $job->handle($app->make(Lot::class));
        });
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
