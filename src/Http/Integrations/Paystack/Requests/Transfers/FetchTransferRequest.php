<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FetchTransferRequest extends Request 
{   
    public function __construct(protected string $id_or_code) {
    }

    protected Method $method = Method::GET; 

    public function resolveEndpoint(): string
    {
        return '/transfer/' . $this->id_or_code;
    }
}