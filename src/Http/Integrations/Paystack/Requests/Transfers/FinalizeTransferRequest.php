<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class FinalizeTransferRequest extends Request implements HasBody
{
    use HasJsonBody;
    
    public function __construct(protected string $transfer_code, protected string $otp) {
    }
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/transfer/finalize_transfer';
    }

    protected function defaultBody(): array
    {
        return [
            "transfer_code" => $this->transfer_code,
            "otp" => $this->otp
        ];
    }
}