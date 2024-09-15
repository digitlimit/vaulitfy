<?php

use App\Services\Vault\Secret;
use Illuminate\Support\Env;

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param mixed|null $default
     * @return mixed
     */
    function env($key, mixed $default = null): mixed
    {
        if(!is_string($key) || str_contains($key, 'VAULT_')) {
           return Env::get($key, $default);
        }

        return vault($key, $default) ?? Env::get($key, $default);
    }
}

if (! function_exists('vault')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed|null $default
     * @return string|null
     */
    function vault(string $key, mixed $default = null): ?string
    {
        $secret = app(Secret::class);

        if ($secret->hasOnly() && ! $secret->inOnly($key)) {
            return null;
        }

        if (! $secret->cacheable()) {
            return $secret->read($key);
        }

        return $secret->cache($key, $default);
    }
}
