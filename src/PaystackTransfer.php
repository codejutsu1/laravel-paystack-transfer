<?php

namespace Codejutsu1\LaravelPaystackTransfer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PaystackTransfer
{
    protected ?string $secret_key;

    protected ?string $public_key;

    protected object $response;

    protected array $transfer_parameters;

    public function __construct()
    {
        $this->setKeys();

        $this->transfer_parameters = [
            "currency" => "NGN",
            "source" => "balance"
        ];
    }

    protected function setKeys()
    {
        $this->secret_key = config('paystack-transfer.secret_key');
        $this->public_key = config('paystack-transfer.public_key');
    }

    public function createTransferRecipient(array $parameters): array
    {
        //$data = ['type', 'name', 'account_number', 'bank_code', 'currency'];
        return Http::withToken($this->secret_key)
                    ->post("https://api.paystack.co/transferrecipient", $parameters)
                    ->json();
    }

    public function bulkTransferRecipient(array $parameters): array
    {
        return Http::withToken($this->secret_key)
                    ->post("https://api.paystack.co/transferrecipient/bulk", $parameters)
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

    public function singleTransfer(array $parameters): array 
    {
        return Http::withToken($this->secret_key)
                    ->post("https://api.paystack.co/transfer", $parameters)
                    ->json();
    }

    /**
     * OTP Enabled
     */
    public function finalizeTransfer(array $parameters): array
    {
        return Http::withToken($this->secret_key)
                    ->post("https://api.paystack.co/transfer/finalize_transfer", $parameters)
                    ->json();
    }

    public function bulkTransfer(array $transfers): array
    {
        $data = array_merge($this->transfer_parameters, $transfers);

        return Http::withToken($this->secret_key)
                    ->post("https://api.paystack.co/transfer/bulk", $data)
                    ->json();
    }

    public function listTransfers(array $queryParameters): array
    {
        return Http::withToken($this->secret_key)
                    ->get("https://api.paystack.co/transfer", $queryParameters)
                    ->json();
    }

    public function fetchTransfer(int|string $id_or_code): array
    {
        return Http::withToken($this->secret_key)
                    ->get("https://api.paystack.co/transfer/{$id_or_code}")
                    ->json();
    }

    public function verifyTransfer(string $reference): array
    {
        return Http::withToken($this->secret_key)
                    ->get("https://api.paystack.co/transfer/verify/{$reference}")
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
