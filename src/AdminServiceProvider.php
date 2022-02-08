<?php

namespace Aphly\LaravelAdmin;


use Illuminate\Support\ServiceProvider;

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
        ]);
        $this->publishes([__DIR__.'/public' => public_path('vendor/laravel-admin')]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-admin');
    }


}
