<?php

namespace Codejutsu1\LaravelPaystackTransfer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PaystackTransfer
{
    protected ?string $secret_key;

    protected ?string $public_key;

    protected object $response;

    public function __construct()
    {
        $this->setKeys();
    }

    protected function setKeys()
    {
        $this->secret_key = config('paystack-transfer.secret_key');
        $this->public_key = config('paystack-transfer.public_key');
    }

    public function listTransferRecipient(int $perPage=null, int $page=null, string $from=null, string $to=null): self
    {
        $this->response = Http::withToken($this->secret_key)
                    ->get("https://api.paystack.co/transferrecipient", [
                        "perPage" => $perPage,
                        "page" => $page,
                        "from" => $from,
                        "to" => $to,
                    ]);

        return $this;
    }

    public function fetchTransferRecipient(int|string $id_or_code): array 
    {
        return Http::withToken($this->secret_key)
                            ->get("https://api.paystack.co/transferrecipient/{$id_or_code}")
                            ->json();
    }

    public function json(): array
    {
        return $this->response;
    }

    public function collect(): collection
    {
        return collect($this->response['data']);
    }
}
