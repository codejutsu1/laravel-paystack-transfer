<?php

namespace Codejutsu1\LaravelPaystackTransfer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Codejutsu1\LaravelPaystackTransfer\Commands\PaystackTransferCommand;

class PaystackTransferServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-paystack-transfer')
            ->hasConfigFile()
            ->hasCommand(PaystackTransferCommand::class);
    }
}
