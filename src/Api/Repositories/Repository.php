<?php

namespace Axyr\Nextcloud\Api\Repositories;

use Axyr\Nextcloud\Api\Api;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

abstract class Repository
{
    public function __construct(protected readonly Api $api) {}

    public function httpClient(): PendingRequest
    {
        return Http::withBasicAuth(
            $this->api->config()->getUsername(),
            $this->api->config()->getPassword(),
        )
            ->withHeaders($this->api->config()->getDefaultHeaders());
    }

    public function getUrl(string $path): string
    {
        return Str::finish($this->api->config()->getBaseUrl(), '/') . $path;
    }
}
