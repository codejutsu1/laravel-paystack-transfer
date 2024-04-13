<?php

use Saloon\Http\Faking\MockClient;
use Codejutsu1\LaravelPaystackTransfer\Tests\TestCase;

uses(TestCase::class) 
            ->beforeEach(fn () => MockClient::destroyGlobal())
            ->in(__DIR__);
