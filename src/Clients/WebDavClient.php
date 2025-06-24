<?php

namespace Axyr\Nextcloud\Clients;

use Axyr\Nextcloud\Contracts\ConfigInterface;
use Axyr\Nextcloud\Enums\Depth;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WebDavClient
{
    private PendingRequest $client;

    private ?WebDavNamespace $namespace = null;

    private Depth $depth = Depth::Zero;

    public function __construct(readonly private ConfigInterface $config)
    {
        $this->client = Http::withBasicAuth(
            $this->config->getUsername(),
            $this->config->getPassword()
        )
            ->baseUrl($this->getBaseUrl())
            ->withHeaders([
                'Content-Type' => 'application/xml',
            ]);
    }

    public function client(): PendingRequest
    {
        return $this->client;
    }

    public function forNamespace(WebDavNamespace $namespace): static
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function withDepth(Depth $depth): static
    {
        $this->depth = $depth;

        return $this;
    }

    protected function getBaseUrl(): string
    {
        return Str::finish($this->config->getBaseUrl(), '/') . Str::finish($this->config->getWebDavEntryPoint(), '/');
    }

    protected function fullPath(?string $path = null): string
    {
        if ($this->namespace) {
            return $this->namespace->value . '/' . $this->config->getUsername() . '/' . ltrim((string)$path, '/');
        }

        return ltrim((string)$path, '/');
    }

    public function propFind(?string $path = null, string $body = '', array $headers = []): Response
    {
        $headers = array_merge([
            'Depth' => $this->depth->value,
        ], $headers);

        return $this->client
            ->withHeaders($headers)
            ->send('PROPFIND', $this->fullPath($path), ['body' => $body]);
    }

    public function createDirectory(string $path, array $headers = []): Response
    {
        return $this->client
            ->withHeaders($headers)
            ->send('MKCOL', $this->fullPath($path));
    }

    public function put(string $path, string $content, array $headers = []): Response
    {
        return $this->client
            ->withHeaders($headers)
            ->send('PUT', $this->fullPath($path), ['body' => $content]);
    }

    public function move(string $source, string $destination, array $headers = []): Response
    {
        return $this->client
            ->withHeaders(
                array_merge([
                    'Destination' => $this->fullPath($destination),
                ], $headers)
            )
            ->send('MOVE', $this->fullPath($source));
    }

    public function delete(string $path, array $headers = []): Response
    {
        return $this->client
            ->withHeaders($headers)
            ->send('DELETE', $this->fullPath($path));
    }

    public function copy(string $source, string $destination, array $headers = []): Response
    {
        return $this->client
            ->withHeaders(
                array_merge([
                    'Destination' => $this->fullPath($destination),
                ], $headers)
            )
            ->send('COPY', $this->fullPath($source));
    }

    public function lock(string $path, string $body = '', array $headers = []): Response
    {
        return $this->client
            ->withHeaders($headers)
            ->send('LOCK', $this->fullPath($path), ['body' => $body]);
    }
}
