<?php

namespace Aphly\LaravelAdmin;

use Aphly\Laravel\Providers\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
		$this->mergeConfigFrom(
            __DIR__.'/config/admin.php', 'admin'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/admin.php' => config_path('admin.php'),
            //__DIR__.'/public' => public_path('static/admin')
        ]);
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-admin');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }



}
