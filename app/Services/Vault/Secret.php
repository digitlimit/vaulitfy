<?php

namespace App\Services\Vault;

class Secret
{
    protected string $environment;

    public function __construct(
       private readonly API $api
    ){
        $this->setEnvironment(config('vault.secret'));
    }

    public function setEnvironment(string $environment): static
    {
        $this->environment = $environment;
        return $this;
    }

    public function readPath(): string
    {
        return config("vault.secrets.{$this->environment}.read_path");
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
