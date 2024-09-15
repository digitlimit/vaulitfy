<?php

namespace App\Services\Vault\Support;

use Illuminate\Support\Env as BaseEnv;
use App\Services\Vault\Secret;


class Env extends BaseEnv
{
    public static function get($key, $default = null)
    {
        $path = 'secret/data/' . $key;
        $secret = app(Secret::class);

        return parent::get($key, $default);


//        $variables = config('vault.env');
//
//        dd(config('app'));
//
//        // If the key is not in the list of variables to be fetched from Vault
//        if (! in_array($key, $variables)) { dd($key, $default, 'Not fetching secret from Vault');
//            return parent::get($key, $default);
//        }
//
//        // Fetch the secret from Vault
//        dd($key, $default, 'Fetching secret from Vault');
//
//        $loader = app(Loader::class);
//
//        $secret = $loader->secret($key);
//
//        return $secret ?: parent::get($key, $default);
    }
}
