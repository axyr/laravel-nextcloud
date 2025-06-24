<?php

namespace Axyr\Nextcloud\Api\Dav;

use Axyr\Nextcloud\Enums\Depth;
use Axyr\Nextcloud\Enums\Favorite;
use Axyr\Nextcloud\Enums\Overwrite;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\ValueObjects\Dav\Resource;
use Illuminate\Support\Collection;

class FilesEndpoint extends AbstractDavEndpoint
{
    public function webDavNamespace(): WebDavNamespace
    {
        return WebDavNamespace::Files;
    }

    /**
     * @return Collection<Resource>
     */
    public function list(?string $path = null, Depth $depth = Depth::Infinity): Collection
    {
        $response = $this->client->withDepth($depth)->propFind($path);

        $this->throwExceptionIfNotOk($response);

        return collect(WebDavXmlParser::parse($response->body()))->mapInto(Resource::class);
    }

    public function downloadFile(string $path): string
    {
        $response = $this->client->get($path);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }

    public function downloadFolder(string $path): string
    {
        $response = $this->client->withHeaders(['Accept' => 'application/zip'])->get($path);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }

    public function createFolder(string $path): bool
    {
        $response = $this->client->createDirectory($path);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function delete(string $path): bool
    {
        $response = $this->client->delete($path);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function move(string $source, string $destination, Overwrite $overwrite = Overwrite::No): bool
    {
        $response = $this->client->move($source, $destination, $overwrite);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function copy(string $source, string $destination, Overwrite $overwrite = Overwrite::No): bool
    {
        $response = $this->client->copy($source, $destination, $overwrite);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function favorites(): Collection
    {
        $body = '<?xml version="1.0"?><oc:filter-files xmlns:d="DAV:" xmlns:oc="http://owncloud.org/ns" xmlns:nc="http://nextcloud.org/ns"><oc:filter-rules><oc:favorite>1</oc:favorite></oc:filter-rules></oc:filter-files>';

        $response = $this->client->report($body);

        $this->throwExceptionIfNotOk($response);

        return collect(WebDavXmlParser::parse($response->body()))->mapInto(Resource::class);
    }

    public function markAsFavorite(string $path): bool
    {
        return $this->setFavorite($path);
    }

    public function unMarkAsFavorite(string $path): bool
    {
        return $this->setFavorite($path, Favorite::No);
    }

    public function setFavorite(string $path, Favorite $favorite = Favorite::Yes): bool
    {
        $body = '<?xml version="1.0"?><d:propertyupdate xmlns:d="DAV:" xmlns:oc="http://owncloud.org/ns"><d:set><d:prop><oc:favorite>' . $favorite->value . '</oc:favorite></d:prop></d:set></d:propertyupdate>';

        $response = $this->client->propPatch($path, $body);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

}
