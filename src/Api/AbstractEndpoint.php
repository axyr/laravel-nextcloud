<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Contracts\ConfigInterface;
use Axyr\Nextcloud\Exception\NextCloudApiException;
use Axyr\Nextcloud\ValueObjects\InvalidRequest;
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
            ->baseUrl(Str::finish($this->config->getBaseUrl(), '/'))
            ->withHeaders($this->config->getDefaultHeaders());
    }

    protected function apiGet($path, array $query = []): Response
    {
        return $this->httpClient()->get($path, $query);
    }

    protected function apiPost($path, array $data = []): Response
    {
        return $this->httpClient()->post($path, $data);
    }

    protected function apiPut($path, array $data = []): Response
    {
        return $this->httpClient()->put($path, $data);
    }

    protected function apiDelete($path, array $data = []): Response
    {
        return $this->httpClient()->delete($path, $data);
    }

    protected function throwExceptionIfNotOk(Response $response): void
    {
        if ( ! $response->ok()) {
            $message = new InvalidRequest($response->json('ocs.meta'));
            throw new NextCloudApiException($message->message(), $message->statuscode());
        }
    }
}
