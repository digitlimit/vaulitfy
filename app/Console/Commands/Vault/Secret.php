<?php

namespace App\Console\Commands\Vault;

use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use App\Services\Vault\Secret as VaultSecret;

class Secret extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vault:secret';

    /**
     * Sync the environment variables with the Vault server.
     *
     * @var string
     */
    protected $description = 'Secret command.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $secret = app(VaultSecret::class);

        dd($secret->all());
    }
}
