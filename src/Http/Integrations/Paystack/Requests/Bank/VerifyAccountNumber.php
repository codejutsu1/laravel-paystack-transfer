<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Bank;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class VerifyAccountNumberRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/bank/resolve';
    }
}