<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack;

use Saloon\Http\Connector;
use Saloon\Http\Auth\TokenAuthenticator;

class PaystackConnector extends Connector
{
    public ?int $tries = 2;

    public ?int $retryInterval = 200;

    public function resolveBaseUrl(): string
    {
        return 'https://api.paystack.co/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator(config('paystack-transfer.secret_key'));
    }
}