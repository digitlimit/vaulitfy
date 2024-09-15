<?php

namespace App\Services\Vault;

use Dotenv\Dotenv;

class EnvReader
{
    private string $path;

    private string $filename;

    private array $env = [];

    public function __construct()
    {
        $this->setPath(base_path());
        $this->setFilename('.env');
    }

    public function load(string $path = null, string $filename = null): self
    {
        if ($path) {
            $this->setPath($path);
        }

        if ($filename) {
            $this->setFilename($filename);
        }

        $dotEnv = Dotenv::createMutable(
            $this->getPath(),
            $this->getFilename()
        );

        $this->env = $dotEnv->load();

        return $this;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function find($key, $default = null): mixed
    {
        return $this->env[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->env;
    }
}
