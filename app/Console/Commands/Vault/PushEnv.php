<?php

namespace App\Console\Commands\Vault;

use Illuminate\Console\Command;
use Dotenv\Dotenv;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PushEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vault:push-env {path} {--env=} {--force}';

    /**
     * Sync the environment variables with the Vault server.
     *
     * @var string
     */
    protected $description = 'Sync the environment variables with the Vault server.';

    /**
     * Execute the console command.
     * @throws ConnectionException
     */
    public function handle(): int
    {
        $envPath = $this->option('env') ?? base_path('.env');
        $envDir = dirname($envPath);

        if (!file_exists($envPath)) {
            $this->error("The .env file at path '{$envPath}' does not exist.");
            return 1;
        }

        // Load the .env file
        $dotenv = Dotenv::createMutable($envDir, basename($envPath));
        $envVars = $dotenv->load();
        $url = config('vault.address') . '/' . $this->argument('path');

        // Push the environment variables to the Vault server
        $response = Http::withToken(config('vault.token'))
            ->put($url, ['data' => $envVars,]);

        return 0;
    }
}
