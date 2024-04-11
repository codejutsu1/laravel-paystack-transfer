<?php

namespace Codejutsu1\LaravelPaystackTransfer;

use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Codejutsu1\LaravelPaystackTransfer\Commands\PaystackTransferCommand;
use Spatie\LaravelPackageTools\Package;                                 

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
            ->name('codejutsu1/laravel-paystack-transfer')
            ->hasConfigFile()
            ->publishesServiceProvider('Codejutsu1\LaravelPaystackTransfer\PaystackTransferServiceProvider')
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    ->startWith(function(InstallCommand $command) {
                        $command->info('Hello, and welcome to my new Laravel Paystack Transfer package!');
                        $command->newLine(2);
                    })
                    ->publishConfigFile()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('codejutsu1/laravel-vtung')
                    ->endWith(function(InstallCommand $command) {
                        $command->newLine(2);
                        $command->info('Have a great day and no forget Enjoy oh!');
                    });
            });
    }
}
