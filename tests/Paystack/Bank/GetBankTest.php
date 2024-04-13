<?php


use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\PaystackConnector;

use Codejutsu1\LaravelPaystackTransfer\Http\Integrations\Paystack\Requests\Bank\GetBanksRequest;
 
// it("returns banks", function(){
//     $mockClient = new MockClient([
//         GetBanksRequest::class => MockResponse::fixture('banks'),
//     ]);

//     $connector = new PaystackConnector;
//     $connector->withMockClient($mockClient);

//     $connector->send(new GetBanksRequest);

//     $mockClient->assertSent(function (Request $request) {
//         expect($request->body()->all())
//             ->toBeJson();
//     }); 
// });