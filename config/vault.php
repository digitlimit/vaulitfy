<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Vault Address
    |--------------------------------------------------------------------------
    |
    | This value is the address of the Vault server.
    |
    */

    'address' => env('VAULT_ADDR', 'http://localhost:8200'),
    'token' => env('VAULT_TOKEN', 's.0Y'),

    'secrets' => [
        'staging' => [
            'path' => 'vaultify/staging',
            'secret' => 'laravel/env',
            'read_path' => '/vaultify/staging/data/laravel/env'
        ],
        'production' => [
            'path' => 'vaultify/production',
            'secret' => 'laravel/env',
            'read_path' => '/vaultify/production/data/laravel/env'
        ]
    ],

    'secret' => env('APP_ENV', 'staging'),
];
