<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Bank;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBanksRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected array $queryParameters) {
    }

    public function resolveEndpoint(): string
    {
        return '/bank';
    }

    protected function defaultQuery(): array
    {
        return $this->queryParameters;
    }
}