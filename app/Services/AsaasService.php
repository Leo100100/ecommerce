<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AsaasService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.asaas.base_url');
        $this->apiKey = config('services.asaas.api_key');
    }

    public function request()
    {
        return \Illuminate\Support\Facades\Http::withHeaders([
            'access_token' => $this->apiKey,
            'Content-Type' => 'application/json',
        ]);
    }

    public function createCustomer($data)
    {
        return $this->request()
            ->post($this->baseUrl . '/customers', $data)
            ->json();
    }

    public function createPayment($data)
    {
        return $this->request()
            ->post($this->baseUrl . '/payments', $data)
            ->json();
    }
}
