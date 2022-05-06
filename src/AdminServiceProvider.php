<?php

namespace Aphly\LaravelAdmin;

use Aphly\LaravelAdmin\Middleware\Common;
use Aphly\LaravelAdmin\Middleware\ManagerAuth;
use Aphly\LaravelAdmin\Middleware\Rbac;
use Aphly\LaravelAdmin\Middleware\UserAuth;
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
            __DIR__.'/public_laravel' => public_path('vendor/laravel'),
            __DIR__.'/public' => public_path('vendor/laravel-admin')
        ]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-admin');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->addMiddlewareAlias('managerAuth', ManagerAuth::class);
        $this->addMiddlewareAlias('rbac', Rbac::class);
        $this->addMiddlewareAlias('userAuth', UserAuth::class);
        $this->addMiddlewareAlias('common', Common::class);
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
