<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListTransfersRequest extends Request 
{   
    public function __construct(protected array $queryParameters) {
    }
    protected Method $method = Method::GET; 

    public function resolveEndpoint(): string
    {
        return '/transfer';
    }

    protected function defaultQuery(): array
    {
        return $this->queryParameters;
    }
}