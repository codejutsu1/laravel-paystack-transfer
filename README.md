# Laravel Paystack Transfer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codejutsu1/laravel-paystack-transfer.svg?style=flat-square)](https://packagist.org/packages/codejutsu1/laravel-paystack-transfer)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/codejutsu1/laravel-paystack-transfer/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/codejutsu1/laravel-paystack-transfer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/codejutsu1/laravel-paystack-transfer/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/codejutsu1/laravel-paystack-transfer/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/codejutsu1/laravel-paystack-transfer.svg?style=flat-square)](https://packagist.org/packages/codejutsu1/laravel-paystack-transfer)

> A Laravel package to make single and bulk transfers with [Paystack](https://paystack.com/docs/transfers/).

## Installation

[PHP](https://www.php.net/) 8.2+ and [Composer](https://getcomposer.org/) are required.

Compatible with Laravel 9, 10, 11.

- Install the package via composer:

    ```bash
    composer require codejutsu1/laravel-paystack-transfer
    ```

- `Optional` you can publish the config file via this command:

    ```bash
    php artisan paystack-transfer:install
    ```

    A configuration file named `paystack-transfer.php` will be placed in the `config` folder of your laravel application:

    ```php
    <?php

    // config for Codejutsu1/LaravelPaystackTransfer
    return [
        /**
         * Public Key From Paystack Dashboard
         *
         */
        'public_key' => env('PAYSTACK_PUBLIC_KEY'),

        /**
         * Secret Key From Paystack Dashboard
         *
         */
        'secret_key' => getenv('PAYSTACK_SECRET_KEY'),

    ];

    ```

### Table of Contents
- Transfer Recipient
- Get Banks
- Verify Account Number
- Single Transfer 
- Finalize Transfers
- Bulk Transfer
- Transfers
    - List Transfers
    - Fetch Transfers
    - Verify Transfers

## Usage
Open your `.env` file and add your public and secret API keys. 

```
PAYSTACK_PUBLIC_KEY=
PAYSTACK_SECRET_KEY=
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Daniel Dunu](https://github.com/codejutsu1)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
