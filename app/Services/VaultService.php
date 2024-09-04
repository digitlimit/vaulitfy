<?php

namespace App\Services;
class VaultService
{
    protected $vaultClient;
    protected $token;

    public function __construct()
    {
        $this->vaultClient = new VaultClient(new Client(), config('vault.base_uri'));
        $this->token = $this->getToken();
    }

    public function getToken()
    {
        // Retrieve token from your environment or use a dynamic approach
        return config('vault.token');
    }

    public function read($path)
    {
        $response = $this->vaultClient->withToken($this->token)->secrets()->read($path);

        return $response->getData();
    }

    public function write($path, array $data)
    {
        $response = $this->vaultClient->withToken($this->token)->secrets()->write($path, $data);

        return $response->getData();
    }

    public function handleTokenRotation()
    {
        // Logic to handle token rotation, e.g., renewing it before expiration
        // Use Vault's built-in token renewal capabilities
        $renewalResponse = $this->vaultClient->withToken($this->token)->auth()->tokenRenew();

        if ($renewalResponse->isSuccessful()) {
            $this->token = $renewalResponse->getAuth()->getClientToken();
            // Optionally, save the new token in a secure place
        }
    }
}
