<?php

namespace App\Services\Vault;

class Secret
{
    protected string $readPath;

    protected ?API $api;

    public function __construct(
        private readonly EnvReader $envReader
    ){
    }

    public function setApi(API $api): static
    {
        $this->api = $api;
        return $this;
    }

    public function api(): API
    {
        if ($this->api) {
            return $this->api;
        }

        $env = $this->envReader->load()->all();

        $this->api = (new API())
            ->setAddress($env['VAULT_ADDR'])
            ->setToken($env['VAULT_TOKEN']);

        return $this->api;
    }

    public function setReadPath(string $readPath): static
    {
        $this->readPath = $readPath;
        return $this;
    }

    public function readPath(): string
    {
        return $this->readPath;
    }

    public function read(string $path = null, array $data = []): ?array
    {
        $path = $path ?? $this->readPath();

        return $this->api->get($path, $data);
    }

    public function write(string $path = null, array $data = []): ?array
    {
        $path = $path ?? $this->readPath();

        return $this->api->post($path, $data);
    }
}
