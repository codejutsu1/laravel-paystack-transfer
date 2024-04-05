<?php

if (! function_exists("transfer"))
{
    function transfer() {

        return app()->make(\Codejutsu1\LaravelPaystackTransfer\PaystackTransfer::class);
    }
}