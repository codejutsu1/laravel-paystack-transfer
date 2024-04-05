<?php

namespace Codejutsu1\LaravelPaystackTransfer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Codejutsu1\LaravelPaystackTransfer\PaystackTransfer
 */
class PaystackTransfer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Codejutsu1\LaravelPaystackTransfer\PaystackTransfer::class;
    }
}
