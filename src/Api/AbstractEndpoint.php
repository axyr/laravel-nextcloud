<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Clients\HttpClient;
use Axyr\Nextcloud\Clients\WebDavClient;
use Axyr\Nextcloud\Contracts\ConfigInterface;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Axyr\Nextcloud\Exception\NextCloudApiException;
use Axyr\Nextcloud\ValueObjects\InvalidRequest;
use Illuminate\Http\Client\Response;

abstract class AbstractEndpoint
{
    public function __construct(
        protected ConfigInterface $config,
        protected readonly HttpClient $http,
        protected readonly WebDavClient $dav
    ) {}

    protected function apiGet($path, array $query = []): Response
    {
        return $this->http->client()->get($path, $query);
    }

    protected function apiPost($path, array $data = []): Response
    {
        return $this->http->client()->post($path, $data);
    }

    protected function apiPut($path, array $data = []): Response
    {
        return $this->http->client()->put($path, $data);
    }

    protected function apiDelete($path, array $data = []): Response
    {
        return $this->http->client()->delete($path, $data);
    }

    protected function davGet(WebDavNamespace $namespace, $path): Response
    {
        return $this->dav->propFind($namespace, $path);
    }

    protected function throwExceptionIfNotOk(Response $response): void
    {
        if ( ! $response->ok()) {
            $message = new InvalidRequest($response->json('ocs.meta'));
            throw new NextCloudApiException($message->message(), $message->statuscode());
        }
    }

    protected function dumpResponse(Response $response): void
    {
        dd($response->getBody()->getContents());
    }
}
