<?php

namespace App\Services\Vault;

readonly class Token
{
    public function __construct(
       private API $api
    ){}

    public function rotate()
    {
        $response = $this->api
            ->post('auth/token/renew-self');
    }
}
