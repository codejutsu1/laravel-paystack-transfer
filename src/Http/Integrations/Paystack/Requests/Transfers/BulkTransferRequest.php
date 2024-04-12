<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class BulkTransferRequest extends Request implements HasBody
{
    use HasJsonBody;
    
    public function __construct(protected array $parameters) {
    }
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/transfer/bulk';
    }

    protected function defaultBody(): array
    {
        return $this->parameters;
    }
}