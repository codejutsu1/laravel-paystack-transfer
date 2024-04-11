<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Bank;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class VerifyAccountNumberRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $account_number, protected string $bank_code) {
    }

    public function resolveEndpoint(): string
    {
        return '/bank/resolve';
    }

    public function defaultQuery(): array
    {
        return [
            'account_number' => $this->account_number,
            'bank_code' => $this->bank_code
        ];
    }
}