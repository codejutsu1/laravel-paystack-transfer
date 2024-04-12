<?php

namespace Codejutsu1\LaravelPaystackTransfer;

use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\PaystackConnector;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Bank\GetBanksRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers\BulkTransferRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers\FetchTransferRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers\ListTransfersRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Bank\VerifyAccountNumberRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers\SingleTransferRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers\VerifyTransferRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Transfers\FinalizeTransferRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient\BulkTransferRecipientRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient\FetchTransferRecipientRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient\ListTransferRecipientsRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient\CreateTransferRecipientRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient\DeleteTransferRecipientRequest;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\TransferRecipient\UpdateTransferRecipientRequest;

class PaystackTransfer
{
    protected array $transfer_parameters;

    protected $connector;

    public function __construct()
    {
       $this->connector = new PaystackConnector;

        $this->transfer_parameters = [
            "source" => "balance"
        ];
    }

    public function createTransferRecipient(array $parameters): array
    {
        return $this->connector->send(new CreateTransferRecipientRequest($parameters))
                                ->json();
    }

    public function bulkTransferRecipient(array $parameters): array
    {
        $batches = $this->batches($parameters);

        $parameters_count = count($parameters) - 1;

        foreach ($batches as $key => $value) {
            $response[] = $this->connector->send(new BulkTransferRecipientRequest($value))
                                        ->json();

            if($key === $parameters_count) break;

            sleep(5);
        }

        return $response;
    }

    public function listTransferRecipients(array $queryParameters=[]): array
    {
        return $this->connector->send(new ListTransferRecipientsRequest)->json();
    }

    public function fetchTransferRecipient(int|string $id_or_code): array 
    {
        return $this->connector->send(new FetchTransferRecipientRequest($id_or_code))->json();
    }

    public function updateTransferRecipient(int|string $id_or_code, array $parameters): array
    {
        return $this->connector->send(new UpdateTransferRecipientRequest($id_or_code, $parameters))
                                ->json();
    }

    public function deleteTransferRecipient(int|string $id_or_code): array
    {
        return $this->connector->send(new DeleteTransferRecipientRequest($id_or_code))
                                ->json();
    }

    public function getBanks(array $queryParameters=[]): array
    {
        return $this->connector->send(new GetBanksRequest)->json();
    }

    public function getBankCode(string $bankName): string
    {
        return $this->connector->send(new GetBanksRequest)
                                    ->collect('data')
                                    ->where('name', $bankName)
                                    ->value('code');
    }

    public function verifyAccountNumber(string $accountNumber, string $bankCode): array 
    {
        return $this->connector->send(new VerifyAccountNumberRequest($accountNumber, $bankCode))
                                ->json();
    }

    public function singleTransfer(array $parameters): array 
    {
        $parameters = array_merge($this->transfer_parameters, $parameters);

        return $this->connector->send(new SingleTransferRequest($parameters))->json();
    }

    /**
     * If OTP Enabled
     */
    public function finalizeTransfer(string $transfer_code, string $otp): array
    {
        return $this->connector->send(new FinalizeTransferRequest($transfer_code, $otp))
                                ->json();
    }

    public function bulkTransfer(array $transfers): array
    {
        $batches = $this->batches($transfers);

        $transfers_count = count($transfers) - 1;
        
        foreach ($batches as $key => $value) {
            $data = array_merge($this->transfer_parameters, ["transfers" => $value]);

            $response[] = $this->connector->send(new BulkTransferRequest($data))->json();

            if($key === $transfers_count) break;

            sleep(5);
        }

        return $response;
    }

    public function listTransfers(array $queryParameters=[]): array
    {
        return $this->connector->send(new ListTransfersRequest)->json();
    }

    public function fetchTransfer(string $id_or_code): array
    {
        return $this->connector->send(new FetchTransferRequest($id_or_code))->json();
    }

    public function verifyTransfer(string $reference): array
    {
        return $this->connector->send(new VerifyTransferRequest($reference))>json();
    }

    private function batches(array $batch): array
    {
        $batch_of = 100;

        $batches = array_chunk($batch, $batch_of);
    
        return $batches;
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
