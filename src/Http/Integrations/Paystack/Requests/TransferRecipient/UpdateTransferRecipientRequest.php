<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class UpdateTransferRecipientRequest extends Request implements HasBody
{
    use HasJsonBody;
    
    protected Method $method = Method::PUT;

    public function __construct(protected int|string $id_or_code, protected array $parameters) 
    {

    }

    public function resolveEndpoint(): string
    {
        return '/transferrecipient/' . $this->id_or_code;
    }

    protected function defaultBody(): array
    {
        return $this->parameters;
    }
}