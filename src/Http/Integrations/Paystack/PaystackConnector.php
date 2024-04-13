<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack;

use Saloon\Http\Response;
use Saloon\Http\Connector;
use Saloon\Http\Auth\TokenAuthenticator;

class PaystackConnector extends Connector
{
    public ?int $tries = 3;

    public ?int $retryInterval = 100;

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

    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();
    
        return new Server(
            status: $data['status'],
            message: $data['message'],
            data: $data['data'] ?? [],
            meta: $data['meta'] ?? [],
        );
    }
}