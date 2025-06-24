<?php

namespace Axyr\Nextcloud\Api\Dav;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\Enums\Depth;
use Axyr\Nextcloud\Enums\Overwrite;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\ValueObjects\Dav\Resource;
use Illuminate\Support\Collection;

class TrashbinEndpoint extends AbstractEndpoint
{
    /**
     * @return Collection<Resource>
     */
    public function list(Depth $depth = Depth::Infinity): Collection
    {
        $response = $this->dav
            ->forNamespace(WebDavNamespace::Trashbin)
            ->withDepth($depth)
            ->propFind('trash');

        $this->throwExceptionIfNotOk($response);

        return collect(WebDavXmlParser::parse($response->body()))->mapInto(Resource::class);
    }

    public function restore(string $path, Overwrite $overwrite = Overwrite::No): bool
    {
        $filename = basename($path);

        $response = $this->dav
            ->forNamespace(WebDavNamespace::Trashbin)
            ->move("trash/{$filename}", "restore/{$filename}", $overwrite);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function delete(string $path): bool
    {
        $response = $this->dav
            ->forNamespace(WebDavNamespace::Trashbin)
            ->delete($path);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function empty(): bool
    {
        $response = $this->dav
            ->forNamespace(WebDavNamespace::Trashbin)
            ->delete('trash');

        $this->throwExceptionIfNotOk($response);

        return true;
    }
}
