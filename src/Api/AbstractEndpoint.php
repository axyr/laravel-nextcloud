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

    protected function httpClient(): PendingRequest
    {
        return Http::withBasicAuth(
            $this->config->getUsername(),
            $this->config->getPassword(),
        )
            ->withHeaders($this->config->getDefaultHeaders());
    }

    protected function apiGet($path, array $query = []): Response
    {
        return $this->httpClient()->get($this->getUrl($path), $query);
    }

    protected function apiPost($path, array $data = []): Response
    {
        return $this->httpClient()->post($this->getUrl($path), $data);
    }

    protected function apiPut($path, array $data = []): Response
    {
        return $this->httpClient()->put($this->getUrl($path), $data);
    }

    protected function apiDelete($path, array $data = []): Response
    {
        return $this->httpClient()->delete($this->getUrl($path), $data);
    }

    protected function getUrl(string $path): string
    {
        return Str::finish($this->config->getBaseUrl(), '/') . $path;
    }

    protected function throwExceptionIfNotOk(Response $response): void
    {
        throw_unless($response->ok(), new NextCloudApiException($response->getReasonPhrase(), $response->getStatusCode()));
    }
}
