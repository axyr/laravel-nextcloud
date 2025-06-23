<?php

namespace Axyr\Nextcloud\Api\Endpoints;

use Axyr\Nextcloud\Api\Api;
use Axyr\Nextcloud\Exception\NextCloudApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

abstract class Endpoint
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

    public function throwExceptionIfNotOk(Response $response): void
    {
        throw_unless($response->ok(), new NextCloudApiException($response->getReasonPhrase(), $response->getStatusCode()));
    }
}
