<?php

namespace App\Console\Commands\Vault;

use Illuminate\Console\Command;
use Dotenv\Dotenv;

class PushEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vault:push-env';

    /**
     * Sync the environment variables with the Vault server.
     *
     * @var string
     */
    protected $description = 'Sync the environment variables with the Vault server.';

    /**
     * Execute the console command.
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

        // Convert the environment variables to JSON
        $jsonOutput = json_encode($envVars, JSON_PRETTY_PRINT);

        $this->info($jsonOutput);

        return 0;
    }
}
