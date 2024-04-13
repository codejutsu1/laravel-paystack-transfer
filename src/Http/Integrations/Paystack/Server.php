<?php

namespace Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack;

class Server {
    public function __construct(
        public readonly bool $status,
        public readonly string $message,
        public readonly array $data,
        public readonly array $meta,
    ){}
}