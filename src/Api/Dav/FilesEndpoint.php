<?php

namespace Axyr\Nextcloud\Api\Dav;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\Enums\Depth;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\ValueObjects\Dav\Resource;
use Illuminate\Support\Collection;

class FilesEndpoint extends AbstractEndpoint
{
    /**
     * @return Collection<Resource>
     */
    public function list(?string $path = null, Depth $depth = Depth::Infinity): Collection
    {
        $response = $this->dav
            ->forNamespace(WebDavNamespace::Files)
            ->withDepth($depth)
            ->propFind($path);

        $this->throwExceptionIfNotOk($response);

        return collect(WebDavXmlParser::parse($response->body()))->mapInto(Resource::class);
    }

    public function downloadFile(string $path): string
    {
        $response = $this->dav
            ->forNamespace(WebDavNamespace::Files)
            ->get($path);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }

    public function downloadFolder(string $path): string
    {
        $response = $this->dav
            ->withHeaders(['Accept' => 'application/zip'])
            ->forNamespace(WebDavNamespace::Files)
            ->get($path);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }

    public function createFolder(string $path): bool
    {
        $response = $this->dav
            ->forNamespace(WebDavNamespace::Files)
            ->createDirectory($path);

        $this->throwExceptionIfNotOk($response);

        return true;
    }
}
