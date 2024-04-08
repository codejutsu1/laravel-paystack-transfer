<?php

namespace Codejutsu1\LaravelPaystackTransfer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PaystackTransfer
{
    protected ?string $secret_key;

    protected ?string $public_key;

    protected array $response;

    protected array $transfer_parameters;

    protected object $request;

    protected string $transfer_recipient_url;

    protected string $bank_url;

    protected string $transfer_url;

    protected string $base_url;

    public function __construct()
    {
        $this->setKeys();

        $this->transfer_parameters = [
            "currency" => "NGN",
            "source" => "balance"
        ];

        $this->request = Http::withToken($this->secret_key);

        $this->base_url = "https://api.paystack.co/";

        $this->transfer_recipient_url = $this->base_url . "transferrecipient";

        $this->bank_url = $this->base_url . "bank";

        $this->transfer_url = $this->base_url . "transfer";
    }

    protected function setKeys()
    {
        $this->secret_key = config('paystack-transfer.secret_key');
        $this->public_key = config('paystack-transfer.public_key');
    }

    public function createTransferRecipient(array $parameters): array
    {
        return $this->request->post($this->transfer_recipient_url, $parameters)
                    ->json();
    }

    public function bulkTransferRecipient(array $batch): array
    {
        return $this->request->post($this->transfer_recipient_url."/bulk", [
                        "batch" => $batch
                    ])
                    ->json();
    }

    public function listTransferRecipient(array $queryParameters=[]): array
    {
        return $this->request->get($this->transfer_recipient_url, $queryParameters)->json();
    }

    public function fetchTransferRecipient(int|string $id_or_code): array 
    {
        return $this->request->get($this->transfer_recipient_url."/{$id_or_code}")
                    ->json();
    }

    public function updateTransferRecipient(int|string $id_or_code, array $parameters): array
    {
        return $this->request->put($this->transfer_recipient_url."/{$id_or_code}", $parameters)
                    ->json();
    }

    public function deleteTransferRecipient(int|string $id_or_code): array
    {
        return $this->request->delete($this->transfer_recipient_url."/{$id_or_code}")
                    ->json();
    }

    public function getBanks(array $queryParameters=[]): array
    {
        return $this->request->get($this->bank_url, $queryParameters)->json();
    }

    public function verifyAccountNumber(array $queryParameters): array 
    {
        return $this->request->get($this->bank_url."/resolve", $queryParameters)
                    ->json();
    }

    public function singleTransfer(array $parameters): array 
    {
        return $this->request->post($this->transfer_url, $parameters)->json();
    }

    /**
     * If OTP Enabled
     */
    public function finalizeTransfer(array $parameters): array
    {
        return $this->request->post($this->transfer_url . "/finalize_transfer", $parameters)
                    ->json();
    }

    public function bulkTransfer(array $transfers): array
    {
        $batch_of = 100;

        $batches = array_chunk($transfers, $batch_of);

        $transfers_count = count($transfers) - 1;
        
        foreach ($batches as $key => $value) {
            $data = array_merge($this->transfer_parameters, ["transfers" => $value]);

            $response[] = $this->request->post($this->transfer_url."/bulk", $data)->json();

            if($key === $transfers_count) break;

            sleep(5);
        }

        return $response;
    }

    public function listTransfers(array $queryParameters): array
    {
        return $this->request->get($this->transfer_url, $queryParameters)
                    ->json();
    }

    public function fetchTransfer(int|string $id_or_code): array
    {
        return $this->request->get($this->transfer_url."/{$id_or_code}")
                    ->json();
    }

    public function verifyTransfer(string $reference): array
    {
        return $this->request->get($this->transfer_url."/verify/{$reference}")
                    ->json();
    }

    // public function json(): array
    // {
    //     return $this->response;
    // }
    
    /**
     * Chain the method and return the data as a collection.... but I want the methods to return as a json by default.
     */
    // public function collect(): collection
    // {
    //     return collect($this->response['data']);
    // }
}
