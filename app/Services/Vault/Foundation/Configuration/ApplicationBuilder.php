<?php

namespace App\Services\Vault\Foundation\Configuration;

use Illuminate\Foundation\Configuration\ApplicationBuilder as BaseApplicationBuilder;

class ApplicationBuilder extends BaseApplicationBuilder
{
    public function withCustomSingletons(array $singletons): static
    {
        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        return $this;
    }

    public function withCustomAliases(array $aliases)
    {
        foreach ($aliases as $abstract => $concrete) {
            $this->app->alias($abstract, $concrete);
        }

        return $this;
    }

    public function withCustomBindings(array $bindings)
    {
        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        return $this;
    }
}
