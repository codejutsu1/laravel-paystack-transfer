<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteTransferRecipientRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(protected readonly int|string $id_or_code) 
    {

    }

    public function resolveEndpoint(): string
    {
        return '/transferrecipient/' . $this->id_or_code;
    }
}