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

    public function createTransferRecipient(array $para): array
    {
        //$data = ['type', 'name', 'account_number', 'bank_code', 'currency'];
        return Http::withToken($this->secret_key)
                    ->post("https://api.paystack.co/transferrecipient", $para)
                    ->json();
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

    public function updateTransferRecipient(int|string $id_or_code, array $para): array
    {
        return Http::withToken($this->secret_key)
                    ->put("https://api.paystack.co/transferrecipient/{$id_or_code}", $para)
                    ->json();
    }

    public function deleteTransferRecipient(int|string $id_or_code): array
    {
        return Http::withToken($this->secret_key)
                    ->delete("https://api.paystack.co/transferrecipient/{$id_or_code}")
                    ->json();
    }

    public function getBanks(array $queryParameters=[]): array
    {
        return Http::withToken($this->secret_key)
                ->get("https://api.paystack.co/bank", $queryParameters)
                ->json();
    }

    public function verifyAccountNumber(array $queryParameters): array 
    {
        return Http::withToken($this->secret_key)
                    ->get("https://api.paystack.co/bank/resolve", $queryParameters)
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
