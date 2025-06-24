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
            ->withHeaders([
                'Content-Type' => 'application/xml',
            ]);
    }

    public function client(): PendingRequest
    {
        return $this->client;
    }

    public function forNamespace(?WebDavNamespace $namespace = null): static
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function withDepth(Depth $depth): static
    {
        $this->depth = $depth;

        return $this;
    }

    public function withHeaders(array $headers = []): static
    {
        $this->client->withHeaders($headers);

        return $this;
    }

    public function getFullPath(?string $path = null): string
    {
        $webDavEntryPoint = Str::finish($this->config->getWebDavEntryPoint(), '/');

        if (Str::contains($path, $webDavEntryPoint)) {
            return $this->getFullUrl($path);
        }

        if ($this->namespace) {
            $path = $this->namespace->value . '/' . $this->config->getUsername() . '/' . ltrim((string)$path, '/');
        }

        return $this->getFullUrl(Str::finish($this->config->getWebDavEntryPoint(), '/') . $path);
    }

    protected function getFullUrl(?string $path = null): string
    {
        return $this->getBaseUrl() . ltrim((string)$path, '/');
    }

    protected function getBaseUrl(): string
    {
        return Str::finish($this->config->getBaseUrl(), '/');
    }

    public function propFind(?string $path = null, string $body = '', array $options = []): Response
    {
        return $this->client
            ->withHeaders(['Depth' => $this->depth->value])
            ->send('PROPFIND', $this->getFullPath($path), ['body' => $body]);
    }

    public function createDirectory(string $path): Response
    {
        return $this->client->send('MKCOL', $this->getFullPath($path));
    }

    public function put(string $path, string $content): Response
    {
        return $this->client->send('PUT', $this->getFullPath($path), ['body' => $content]);
    }

    public function move(string $source, string $destination): Response
    {
        return $this->client
            ->withHeaders(['Destination' => $this->getFullPath($destination)])
            ->send('MOVE', $this->getFullPath($source));
    }

    public function get(string $path): Response
    {
        return $this->client->send('GET', $this->getFullPath($path));
    }

    public function delete(string $path): Response
    {
        return $this->client->send('DELETE', $this->getFullPath($path));
    }

    public function copy(string $source, string $destination): Response
    {
        return $this->client
            ->withHeaders(['Destination' => $this->getFullPath($destination)])
            ->send('COPY', $this->getFullPath($source));
    }

    public function lock(string $path, string $body = ''): Response
    {
        return $this->client->send('LOCK', $this->getFullPath($path), ['body' => $body]);
    }
}
