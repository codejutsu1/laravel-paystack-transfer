<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class BulkTransferRecipientRequest extends Request implements HasBody
{
    use HasJsonBody;
    
    protected Method $method = Method::POST;

    public function __construct(protected array $batch) 
    {

    }

    public function resolveEndpoint(): string
    {
        return '/transferrecipient/bulk';
    }

    protected function defaultBody(): array
    {
        return [
            'batch' => $this->batch,
        ];
    }
}