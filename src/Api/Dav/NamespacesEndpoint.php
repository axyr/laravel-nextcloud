<?php

namespace Axyr\Nextcloud\Api\Dav;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\Enums\Depth;
use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\ValueObjects\Dav\Resource;
use Illuminate\Support\Collection;

class NamespacesEndpoint extends AbstractEndpoint
{
    /**
     * @return Collection<Resource>
     */
    public function list(): Collection
    {
        $response = $this->dav
            ->withDepth(Depth::One)
            ->propFind();

        $xml = $response->getBody()->getContents();

        return collect(WebDavXmlParser::parse($xml))->mapInto(Resource::class);
    }
}
