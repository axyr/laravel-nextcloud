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

        $xml = $response->getBody()->getContents();

        return collect(WebDavXmlParser::parse($xml))->mapInto(Resource::class);
    }
}
