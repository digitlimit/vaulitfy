<?php

namespace App\Services\Vault\Repositories\Config;

use Illuminate\Config\Repository as BaseRepository;
use Illuminate\Support\Arr;

class Repository extends BaseRepository
{
    /**
     * Get the specified configuration value.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return Arr::get($this->items, $key, $default);
    }
}
