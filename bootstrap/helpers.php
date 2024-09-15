<?php

use App\Services\Vault\Support\Env;

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
        return Env::get($key, $default);
    }
}
