<?php

namespace App\Console\Commands;

use App\Token;
use Illuminate\Console\Command;

class CleanTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:clean-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear expired pairing tokens from the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = Token::clean();
        $this->info("Cleaned $count ".str_plural('token', $count).' from the database');
    }
}
