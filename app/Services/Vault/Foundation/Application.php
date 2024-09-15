<?php

namespace App\Services\Vault\Foundation;

use Illuminate\Foundation\Application as BaseApplication;
use App\Services\Vault\Foundation\Configuration\ApplicationBuilder;

class Application extends BaseApplication
{
    /**
     * Begin configuring a new Laravel application instance.
     *
     * @param string|null $basePath
     * @return ApplicationBuilder
     */
    public static function configure(?string $basePath = null): ApplicationBuilder
    {
        $basePath = match (true) {
            is_string($basePath) => $basePath,
            default => static::inferBasePath(),
        };

        return (new ApplicationBuilder(new static($basePath)))
            ->withKernels()
            ->withEvents()
            ->withCommands()
            ->withProviders();
    }
}
