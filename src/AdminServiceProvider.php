<?php

namespace Aphly\LaravelAdmin;

use Aphly\Laravel\Providers\ServiceProvider;
use Aphly\LaravelAdmin\Middleware\Common;
use Aphly\LaravelAdmin\Middleware\Cross;
use Aphly\LaravelAdmin\Middleware\ManagerAuth;
use Aphly\LaravelAdmin\Middleware\Rbac;

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
            __DIR__.'/public' => public_path('aphly/admin')
        ]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-admin');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->addRouteMiddleware('managerAuth', ManagerAuth::class);
        $this->addRouteMiddleware('rbac', Rbac::class);
        $this->addMiddleware(Common::class);
        $this->addRouteMiddleware('cross', Cross::class);
    }



}
