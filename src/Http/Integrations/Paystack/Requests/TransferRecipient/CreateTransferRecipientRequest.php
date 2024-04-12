<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class CreateTransferRecipientRequest extends Request implements HasBody
{
    use HasJsonBody;
    
    protected Method $method = Method::POST;

    public function __construct(protected array $parameters) 
    {

    }

    public function resolveEndpoint(): string
    {
        return '/transferrecipient';
    }

    protected function defaultBody(): array
    {
        return $this->parameters;
    }
}