<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FetchTransferRecipientRequest extends Request 
{   
    protected Method $method = Method::GET;

    public function __construct(protected int|string $id_or_code) 
    {

    }

    public function resolveEndpoint(): string
    {
        return '/transferrecipient/' . $this->id_or_code;
    }
}