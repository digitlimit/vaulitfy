<?php

namespace App\Services\Vault\Repositories\Config;

use App\Services\Vault\Secret;
use Illuminate\Support\Facades\Cache;

readonly class Loader
{
    public function __construct(
        private Secret $secret
    ){}

    public function secret($key, $default = null)
    {

        $cache = config('vault.secret.cache');
        $path = 'secret/data/' . $key;
        $cacheKey = $cache['prefix'] . $key;
dd($cacheKey);
        if (! $cache['enabled']) {
            $secret = $this->secret->read($path);
            return $secret['data'] ?? $default;
        }

        return $this->cache->remember($cacheKey, $cache['ttl'], function () use ($key, $default) {
            $secret = $this->secret->read('secret/data/' . $key);
            return $secret['data'] ?? $default;
        });
    }
}
