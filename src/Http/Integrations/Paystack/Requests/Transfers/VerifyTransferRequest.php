<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class VerifyTransferRequest extends Request 
{   
    public function __construct(protected string $reference) {
    }

    protected Method $method = Method::GET; 

    public function resolveEndpoint(): string
    {
        return '/transfer/verify/' . $this->reference;
    }
}