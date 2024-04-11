<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SingleTransferRequest extends Request implements HasBody
{
    use HasJsonBody;
    
    public function __construct(protected array $parameters) {
    }
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/transfer';
    }
}