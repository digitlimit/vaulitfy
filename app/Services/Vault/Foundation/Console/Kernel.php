<?php

namespace App\Services\Vault\Foundation\Console;

use Illuminate\Foundation\Console\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    /**
     * The bootstrap classes for the application.
     *
     * @var string[]
     */
    protected $bootstrappers = [
//        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
//        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \App\Services\Vault\Bootstrap\LoadEnvironmentVariables::class,
        \App\Services\Vault\Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];
}
