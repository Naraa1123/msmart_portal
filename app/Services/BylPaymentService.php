<?php

namespace App\Services;

use GuzzleHttp\Client;

class BylPaymentService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('BYL_API_KEY');

        $this->client = new Client([
            'base_uri' => env('BYL_BASE_URL'),
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }

    public function createInvoice($amount, $description, $auto_advance)
    {
        $response = $this->client->post('invoices', [
            'json' => [
                'amount' => $amount,
                'description' => $description,
                'auto_advance' => $auto_advance,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

//    public function checkInvoice($invoiceId)
//    {
//        try {
//            $response = $this->client->get("invoices/{$invoiceId}");
//            return json_decode($response->getBody()->getContents(), true);
//        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
//            return response()->json(['error' => $e->getMessage()], $e->getCode());
//        }
//    }

}
