<?php

namespace Codejutsu1\LaravelPaystackTransfer;

use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Server;
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

    public function createTransferRecipient(array $parameters): Server
    {
        return $this->connector->send(new CreateTransferRecipientRequest($parameters))
                                ->dtoOrFail();
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

    public function listTransferRecipients(array $queryParameters=[]): Server
    {
        return $this->connector->send(new ListTransferRecipientsRequest)->dtoOrFail();
    }

    public function fetchTransferRecipient(int|string $id_or_code): Server
    {
        return $this->connector->send(new FetchTransferRecipientRequest($id_or_code))->dtoOrFail();
    }
    // returns status and message.
    public function updateTransferRecipient(int|string $id_or_code, array $parameters): Server
    {
        return $this->connector->send(new UpdateTransferRecipientRequest($id_or_code, $parameters))
                                ->dtoOrFail();
    }

    public function deleteTransferRecipient(int|string $id_or_code): Server
    {
        return $this->connector->send(new DeleteTransferRecipientRequest($id_or_code))
                                ->dtoOrFail();
    }

    public function getBanks(array $queryParameters=[]): Server
    {
        return $this->connector->send(new GetBanksRequest)->dtoOrFail();
    }

    public function getBankCode(string $bankName): string
    {
        return $this->connector->send(new GetBanksRequest)
                                    ->collect('data')
                                    ->where('name', $bankName)
                                    ->value('code');
    }

    public function verifyAccountNumber(string $accountNumber, string $bankCode): Server
    {
        return $this->connector->send(new VerifyAccountNumberRequest($accountNumber, $bankCode))
                                ->dtoOrFail();
    }

    public function singleTransfer(array $parameters): Server 
    {
        $parameters = array_merge($this->transfer_parameters, $parameters);

        return $this->connector->send(new SingleTransferRequest($parameters))->dtoOrFail();
    }

    /**
     * If OTP Enabled
     */
    public function finalizeTransfer(string $transfer_code, string $otp): Server
    {
        return $this->connector->send(new FinalizeTransferRequest($transfer_code, $otp))
                                ->dtoOrFail();
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

    public function listTransfers(array $queryParameters=[]): Server
    {
        return $this->connector->send(new ListTransfersRequest)->dtoOrFail();
    }

    public function fetchTransfer(string $id_or_code): Server
    {
        return $this->connector->send(new FetchTransferRequest($id_or_code))->dtoOrFail();
    }

    public function verifyTransfer(string $reference): Server
    {
        return $this->connector->send(new VerifyTransferRequest($reference))>dtoOrFail();
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
