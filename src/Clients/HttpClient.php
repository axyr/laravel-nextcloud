<?php

namespace Axyr\Nextcloud\Clients;

use Axyr\Nextcloud\Contracts\ConfigInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

readonly class HttpClient
{
    private PendingRequest $client;

    public function __construct(private ConfigInterface $config)
    {
        $this->client = Http::withBasicAuth(
            $this->config->getUsername(),
            $this->config->getPassword(),
        )
            ->baseUrl(Str::finish($this->config->getBaseUrl(), '/'))
            ->withHeaders([
                'OCS-APIRequest' => 'true',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);
    }

    public function client(): PendingRequest
    {
        return $this->client;
    }
}
