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
    'token' => env('VAULT_TOKEN', 's.0Y')
];
