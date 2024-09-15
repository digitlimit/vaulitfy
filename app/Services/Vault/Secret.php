<?php

namespace App\Services\Vault;

use Illuminate\Support\Facades\Cache;

class Secret
{
    protected ?string $readPath = null;

    protected ?API $api = null;

    protected array $env;

    public function __construct(
        private readonly EnvReader $envReader
    ){
        $this->setEnv(
            $this->envReader->load()->all()
        );
    }

    public function read(string $key, string $path = null): ?string
    {
        if ($path){
            $this->setReadPath($path);
        }

        $path = $this->readPath();

        $secrets = $this->api()->get($path) ?? [];

        return $secrets['data'][$key] ?? null;
    }

    public function write(array $data = [], string $path = null): ?array
    {
        if ($path){
            $this->setReadPath($path);
        }

        $path = $this->readPath();

        return $this->api->post($path, $data);
    }

    public function setEnv(array $env): static
    {
        $this->env = $env;
        return $this;
    }

    public function setApi(API $api): static
    {
        $this->api = $api;
        return $this;
    }

    public function setReadPath(string $readPath): static
    {
        $this->readPath = trim($readPath, '/');

        return $this;
    }

    public function api(): API
    {
        if ($this->api) {
            return $this->api;
        }

        $this->api = app(API::class)
            ->setAddress($this->env['VAULT_ADDR'])
            ->setToken($this->env['VAULT_TOKEN']);

        return $this->api;
    }

    public function readPath(): string
    {
        if ($this->readPath) {
            return $this->readPath;
        }

        return $this->defaultReadPath();
    }

    public function cacheable(): bool
    {
        if(! isset($this->env['VAULT_CACHEABLE'])) {
            return false;
        }

        return strtolower($this->env['VAULT_CACHEABLE']) === 'true';
    }

    public function cachePrefix(): string
    {
        return $this->env['VAULT_CACHE_PREFIX'] ?? 'vault:';
    }

    public function cacheKey(string $key): string
    {
        return $this->cachePrefix() . $key;
    }

    public function cacheTtl(): int
    {
        return $this->env['VAULT_TTL'] ?? 60;
    }

    public function cache($key, $default = null)
    {
        $cacheKey = $this->cacheKey($key);

        return Cache::remember(
            $cacheKey,
            $this->cacheTtl(),
            fn() => $this->read($key, $default)
        );
    }

    public function defaultReadPath()
    {
        return $this->env['VAULT_READ_PATH'];
    }

    public function hasOnly(): bool
    {
        return isset($this->env['VAULT_ONLY'])
            && $this->env['VAULT_ONLY'];
    }

    public function only(): array
    {
        if(! $this->hasOnly()) {
            return [];
        }

        $only = explode(',', $this->env['VAULT_ONLY']);

        return array_map('trim', $only);
    }

    public function inOnly(string $key): bool
    {
        $only = $this->only();

        if(empty($only)) {
            return false;
        }

        return in_array($key, $only);
    }
}
