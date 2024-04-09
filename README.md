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

## Usage
Open your `.env` file and add your public and secret API keys. 

```
PAYSTACK_PUBLIC_KEY=
PAYSTACK_SECRET_KEY=
```

## Table of Contents
- Transfer Recipient
    - Create Single Transfer Recipient
    - Create Bulk Transfer Recipient
    - List Transfer Recipients
    - Fetch a Transfer Recipient
    - Update a Transfer Recipient
    - Delete a Transfer Recipient
- Banks
    - Get Banks API
    - Verify Account Number
- Transfers
    - Single Transfers
    - Finalize a Transfer (When OTP is enabled for single Transfers)
    - Bulk Transfers
    - List Transfers
    - Fetch a Transfer
    - Verify a Transfer

## Payment Flow

1. To make a transfer, either single or in bulk using this package, you need to provide an array of four values:
    - amount - Amount to be sent.
    - reference (Transfer Reference) - A unique identifier which will be used to track your transactions. This package provides a helper function, `generateTransferReference()`, which provides a UUID you can use as a unique reference.
    - recipient (Transfer Recipient) - A transfer recipient is a beneficiary that you can send money to. To create a transfer recipient, you need to collect their details first.
    - reason - Reason for the transfer.
    - currency - (Optional) `NGN` by default but you can specify your currency.

```php
<?php

$transfers = [
    "amount": "37800",
    "reference": "your-unique-reference", 
    "recipient": "RCP_t0ya41mp35flk40", 
    "reason": "Holiday Flexing" 
];

```
## Transfer Recipient
### Create Single Transfer Recipient

To create a single transfer recipient:

```php
<?php 

$data = [
    "type" => "nuban", //Recipient type, either nuban, ghipps, mobile_money or bass
    "name" => "Daniel Dunu", //Recipient name
    "account_number" => "01000000010", // Recipient Account Number
    "bank_code" => "058", // Recipient bank code
    "currency" => "NGN", // Recipient Currency
];

$response = PaystackTransfer::createTransferRecipient($data);

if($response['status'] == true){
    // Your code Logic
}else{
    return redirect()->back()->withMessage($response['message']);
}

```

> [!IMPORTANT]
> Store the recipient_code in your database alongside the recipient.

> You can get bank codes by using the [list banks]() methods. 

> For more information, visit [Paystack Create Transfer Recipient](https://paystack.com/docs/transfers/creating-transfer-recipients/).

### Create Bulk Transfer Recipient

You can create multiple transfer recipient in batches. To create multiple transfer recipient:

```php
<?php 

$data = [
    [
        "type" => "nuban", //Recipient type, either nuban, ghipps, mobile_money or bass
        "name" => "Daniel Dunu", //Recipient name
        "account_number" => "01000000010", // Recipient Account Number
        "bank_code" => "058", // Recipient bank code
        "currency" => "NGN", // Recipient Currency
    ],
    [
        "type" => "ghipps", //Recipient type, either nuban, ghipps, mobile_money or bass
        "name" => "John Doe", //Recipient name
        "account_number" => "02000000020", // Recipient Account Number
        "bank_code" => "018", // Recipient bank code
        "currency" => "NGN", // Recipient Currency
    ],
];

$response = PaystackTransfer::bulkTransferRecipient($data);

if($response['status'] == true){
    // Your code Logic
}else{
    return redirect()->back()->withMessage($response['message']);
}
```

### List Transfer Recipients
To list all transfer recipients:
```php
<?php

$response = PaystackTransfer::listTransferRecipients();

if($response['status'] == true){
    // Eg of code logic
    $transferRecipients = collect($response['data']);

    $transferRecipient = $transferRecipients->pluck('recipient_code');

    return $transferRecipient;
}else{
    return redirect()->back()->withMessage($response['message']);
}
```
You can also provide query parameters as an array:
```php
<?php

$queryParameters = [
    "perPage" => 30, //Integer(optional), Records per page.
    "page" => 2, //Integer(optional), exact page to retrieve.
    "from" => "2016-09-24T00:00:05.000Z", //dateTime(optional), Timestamp to start listing transfer recipient.
    "to" => "2016-09-24T00:00:05.000Z", //dateTime(optional), Timestamp to stop listing transfer recipient
];

$response = PaystackTransfer::listTransferRecipients($queryParameters);

return $response;
```

### Fetch a Transfer Recipient
To fetch a transfer recipient, you need to provide the id or recipient code of the recipient:
```php
<?php

$response = PaystackTransfer::fetchTransferRecipient("RCP_2x5j67tnnw1t98k");

if($response['status'] == true){
    // Your code logic here
}else{
    return redirect()->back()->withMessage($response['message']);
}
```
### Update a Transfer Recipient
To update a transfer recipient details, you need to provide the id or recipient code of the recipient alongside the details to be updated (name and/or email):

```php
<?php

$data = [
    'email' => 'danieldunu001@gmail.com'
];

$response = transfer()->updateTransferRecipient("RCP_2x5j67tnnw1t98k", $data);

if($response['status'] == true){
    // Your code logic here
}else{
    return redirect()->back()->withMessage($response['message']);
}
```

### Delete a Transfer Recipient
To delete a transfer recipient, you need to provide the id or recipient code of the recipient:

```php
<?php

$response = transfer()->deleteTransferRecipient("RCP_2x5j67tnnw1t98k");

if($response['status'] == true){
    // Your code logic here
}else{
    return redirect()->back()->withMessage($response['message']);
}
```

## Banks
### Get Banks API

To get lists of banks in Nigeria:

```php
<?php

$response = transfer()->getBanks();

if($response['status'] == true){
    $banks = collect($response['data']); // To a collection.
    // Your logic
}else{
    return redirect()->back()->withMessage($response['message']);
}
```

You can also provide query parameters as an array:

```php
<?php 

$queryParameters = [
    "country" => "ghana", //String(Optional), nigeria or ghana, default is nigeria
    "perPage" => 50,  //Integer(optional), Records per page.
    //Other query parameters in the documentation.
];

$response = transfer()->getBanks($queryParameters);

```

### Get Bank Code
To get a bank code, you need to provide the bank name from the [get bank API]():
```php
<?php 

$code = transfer()->getBankCode("United Bank For Africa");

return $code;
```

### Verify Account Number

To confirm the account belongs to the right customer, you need to provide the account number and the bank code of the customer as both strings:

```php
<?php

$response = PaystackTransfer::verifyAccountNumber(accountNumber:"2134288420", bankCode:"022");

if($response['status'] == true){
    //Your logic
}else{
    return redirect()->back()->withMessage($response['message']);
}
```
## Transfers
### Single Transfers
To make a single transfers, you need these provide four parameters as an array:
- reason
- amount
- reference 
- recipient

The `currency` is `NGN` by default. You can override the default currency by adding it to the array. For the `source`, we took care of that merging the array with a value of `balance`.

```php
<?php

$parameters = [
	"reason": "Savings",
	"amount": 300000, //NGN3000, converted to kobo. 
	"reference": "your-unique-reference",
	"recipient": "RCP_1a25w1h3n0xctjg"
];

$response = PaystackTransfer::singleTransfer($parameters);

if($response['status'] == true){
    //Your logic
}else{
    return redirect()->back()->withMessage($response['message']);
}

```

### Finalize a Transfer
After making a single transfer with OTP enabled, you will have to finalized your transfer by providing the OTP and the transfer code as both strings:

```php
<?php

$response = transfer()->finalizeTransfer(transfer_code:"TRF_vsyqdmlzble3uii", otp: "930322");

if($response['status'] == true){
    //Your logic
}else{
    return redirect()->back()->withMessage($response['message']);
}
```
### Bulk Transfer
To send money to multiple recipients, you need to make request in `batches`. A `batch` is an array of arrays containing the `transfer parameters`. A `batch` should not contain more than `100 arrays` and should be sent `every 5 seconds`.

But you don't have to worry about that, just pass the batch as a parameter. Even if your batch contains more than 100 items, this package will break it down into a batches each containing not more than 100 arrays and make a request every 5 seconds.

```php
<?php

$transfers = [
    [
        "amount"=> 20000,
        "reference"=> "588YtfftReF355894J",
        "reason"=> "Why not?",
        "recipient"=> "RCP_2tn9clt23s7qr28",    
    ],
    [
        "amount"=> 30000,
        "reference"=> "YunoTReF35e0r4J",
        "reason"=> "Because I can",
        "recipient"=> "RCP_1a25w1h3n0xctjg",    
    ],
    [
        "amount"=> 40000,
        "reference"=> generateTransferReference(),
        "reason"=> "Go buy your mama a house",
        "recipient"=> "RCP_aps2aibr69caua7",
    ]
];

/**
 * Returns an array of arrays.
*/
$response = PaystackTransfer::bulkTransfer($transfers);

// For batch with less than 100 arrays

if($response['status'] == true){
    //Your logic
}else{
    return redirect()->back()->withMessage($response['message']);
}

```
> [!Note]
> You need to set up webhooks to keep track of your transfers.
### List Transfers

Paystack gives you the option to list all your transfers:
```php
<?php

$response = PaystackTransfer::listTransfers();

if($response['status'] == true){
    //Your logic
}else{
    return redirect()->back()->withMessage($response['message']);
}

```
You can also provide query parameters as an array:
```php
$queryParameters = [
    "perPage" => 30, //Integer(optional), Records per page.
    "page" => 2, //Integer(optional), exact page to retrieve.
    "customer" => "12121", //String(optional), filter by id.
    "from" => "2016-09-24T00:00:05.000Z", //dateTime(optional), Timestamp to start listing transfer recipient.
    "to" => "2016-09-24T00:00:05.000Z", //dateTime(optional), Timestamp to stop listing transfer recipient
];

$response = PaystackTransfer::listTransfers($queryParameters);
```

### Fetch a Transfer
Get details of a transfer. You need to provide transfer id.
```php
<?php

$response = PaystackTransfer::fetchTransfer("14938");

if($response['status'] == true){
    //Your logic
}else{
    return redirect()->back()->withMessage($response['message']);
}
```
### Verify Transfer
Verify the status of a transfer. You need to provide transfer reference.
```php

$response = PaystackTransfer::verifyTransfer("your_reference");

if($response['status'] == true){
    //Your logic
}else{
    return redirect()->back()->withMessage($response['message']);
}   

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
