<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Contracts\ConfigInterface;
use Axyr\Nextcloud\Exception\NextCloudApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

abstract class AbstractEndpoint
{
    public function __construct(private readonly ConfigInterface $config) {}

    public function httpClient(): PendingRequest
    {
        return Http::withBasicAuth(
            $this->config->getUsername(),
            $this->config->getPassword(),
        )
            ->withHeaders($this->config->getDefaultHeaders());
    }

    public function getUrl(string $path): string
    {
        return Str::finish($this->config->getBaseUrl(), '/') . $path;
    }

    public function throwExceptionIfNotOk(Response $response): void
    {
        throw_unless($response->ok(), new NextCloudApiException($response->getReasonPhrase(), $response->getStatusCode()));
    }
}
