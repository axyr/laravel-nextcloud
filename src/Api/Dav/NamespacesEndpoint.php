<?php

namespace Axyr\Nextcloud\Api\Dav;

use Axyr\Nextcloud\Enums\Depth;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\ValueObjects\Dav\Resource;
use Illuminate\Support\Collection;

class NamespacesEndpoint extends AbstractDavEndpoint
{
    public function webDavNamespace(): WebDavNamespace
    {
        return WebDavNamespace::None;
    }

    /**
     * @return Collection<Resource>
     */
    public function list(): Collection
    {
        $response = $this->client->withDepth(Depth::One)->propFind();

        $this->throwExceptionIfNotOk($response);

        return collect(WebDavXmlParser::parse($response->body()))->mapInto(Resource::class);
    }
}
