<?php

namespace App\Console\Commands\Vault;

use Illuminate\Console\Command;
use App\Services\Vault\Token;

class RotateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vault:rotate-token';

    /**
     * Sync the environment variables with the Vault server.
     *
     * @var string
     */
    protected $description = 'Rotate the Vault token.';

    public function __construct(
        private readonly Token $token
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->token->rotate();
        $this->info('Vault token rotated successfully');
        info('Vault token rotated successfully');
        return 0;
    }
}
