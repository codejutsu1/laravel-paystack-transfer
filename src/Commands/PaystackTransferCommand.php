<?php

namespace Codejutsu1\LaravelPaystackTransfer\Commands;

use Illuminate\Console\Command;

class PaystackTransferCommand extends Command
{
    public $signature = 'laravel-paystack-transfer';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
