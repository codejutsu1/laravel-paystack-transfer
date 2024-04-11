<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListTransferRecipientsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/transferrecipient';
    }
}