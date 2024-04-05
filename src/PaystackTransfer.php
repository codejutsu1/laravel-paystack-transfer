<?php

namespace Codejutsu1\LaravelPaystackTransfer;

class PaystackTransfer
{
    protected ?string $secret_key;

    protected ?string $public_key;

    public function __construct()
    {
        $this->setKeys();
    }

    protected function setKeys()
    {
        $this->secret_key = config('paystack.secretKey');
        $this->public_key = config('paystack.publicKey');
    }

    public function seeConfigKeys()
    {
        return env("PAYSTACK_PUBLIC_KEY");
    }
}
