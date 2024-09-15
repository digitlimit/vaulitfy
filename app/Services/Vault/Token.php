<?php

namespace App\Services\Vault;

use Illuminate\Support\Facades\Artisan;

readonly class Token
{
    public function __construct(
       private API $api
    ){}

    public function rotate(): ?string
    {
        $response = $this->api
            ->post('auth/token/renew-self');

        $newToken = $response['auth']['client_token'] ?? null;

        if ($newToken) {
            $this->update($newToken);
        }

        return $newToken;
    }

    protected function update(string $newToken): void
    {
        // Update the token in the config cache
        config(['vault.token' => $newToken]);

        // Clear the config cache to apply the changes
        Artisan::call('config:clear');
    }
}
