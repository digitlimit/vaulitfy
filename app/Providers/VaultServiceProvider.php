<?php

namespace App\Providers;

use App\Services\Vault\Repositories\Config\Loader as VaultConfigLoader;
use App\Services\Vault\Repositories\Config\Repository as CustomRepository;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;

class VaultServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // instance config
        $this->app->instance(Repository::class, function ($app)
        {dd(77);
            $items = $app['config']->all();
            $loader = $app->make(VaultConfigLoader::class);

            return new CustomRepository($loader, $items);
        });

//        $this->app->singleton('config', function ($app)
//        {
//            $items = $app['config']->all();
//            $loader = $app->make(VaultConfigLoader::class);
//
//            return new CustomRepository($loader, $items);
//        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
