<?php

namespace Aphly\LaravelAdmin;

use Aphly\LaravelAdmin\Middleware\ManagerAuth;
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
        $this->app->make('Aphly\LaravelAdmin\Controllers\AdminController');
        $this->app->make('Aphly\LaravelAdmin\Controllers\ManagerController');
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
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->addMiddlewareAlias('ManagerAuth', ManagerAuth::class);
    }

    protected function addMiddlewareAlias($name, $class)
    {
        $router = $this->app['router'];
        if (method_exists($router, 'aliasMiddleware')) {
            return $router->aliasMiddleware($name, $class);
        }
        return $router->middleware($name, $class);
    }

}
