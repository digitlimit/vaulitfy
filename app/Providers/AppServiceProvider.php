<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Vault\Support\Env;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        dd($this->app);
        // Bind your custom Env class
//        $this->app->bind('env', Env::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
