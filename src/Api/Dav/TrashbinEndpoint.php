<?php

namespace Axyr\Nextcloud\Api\Dav;

use Axyr\Nextcloud\Enums\Depth;
use Axyr\Nextcloud\Enums\Overwrite;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\ValueObjects\Dav\Resource;
use Illuminate\Support\Collection;

class TrashbinEndpoint extends AbstractDavEndpoint
{
    public function webDavNamespace(): WebDavNamespace
    {
        return WebDavNamespace::Trashbin;
    }

    /**
     * @return Collection<Resource>
     */
    public function list(Depth $depth = Depth::Infinity): Collection
    {
        $response = $this->client->withDepth($depth)->propFind('trash');

        $this->throwExceptionIfNotOk($response);

        return collect(WebDavXmlParser::parse($response->body()))->mapInto(Resource::class);
    }

    public function restore(string $path, Overwrite $overwrite = Overwrite::No): bool
    {
        $filename = basename($path);

        $response = $this->client->move("trash/{$filename}", "restore/{$filename}", $overwrite);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function delete(string $path): bool
    {
        $response = $this->client->delete($path);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function empty(): bool
    {
        $response = $this->client->delete('trash');

        $this->throwExceptionIfNotOk($response);

        return true;
    }
}
