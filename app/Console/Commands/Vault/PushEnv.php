<?php

namespace App\Console\Commands\Vault;

use Illuminate\Console\Command;
use App\Services\Vault\EnvReader;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PushEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vault:push-env {path?} {--env=} {--force}';

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

        if (!file_exists($envPath)) {
            $this->error("The .env file at path '{$envPath}' does not exist.");
            return 1;
        }

        // Load the .env file
        $env = app(EnvReader::class)
            ->load()
            ->all();

        $url = $env['VAULT_ADDR'] . '/' . $this->argument('path');

        // Push the environment variables to the Vault server
        $response = Http::withToken($env['VAULT_TOKEN'])
            ->put($url, ['data' => $env,]);

        if ($response->successful()) {
            $this->info("The environment variables have been successfully pushed to the Vault server.");
            return 0;
        }

        $this->error("Failed to push the environment variables to the Vault server.");
        return 1;
    }
}
