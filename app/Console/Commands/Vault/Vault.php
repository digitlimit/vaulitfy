<?php

namespace App\Console\Commands\Vault;

use Illuminate\Console\Command;
use App\Services\Vault\Secret;

class Vault extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vault';

    /**
     * Sync the environment variables with the Vault server.
     *
     * @var string
     */
    protected $description = 'Test Vault connection.';

    public function handle(): int
    {
        $secret = app(Secret::class);

        dd($secret->setEnvironment('staging')->write(null, [
            'key' => 'value',
        ]));

        return 0;
    }
}
