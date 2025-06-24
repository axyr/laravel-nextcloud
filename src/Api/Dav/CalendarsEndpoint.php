<?php

namespace Axyr\Nextcloud\Api\Dav;

use Axyr\Nextcloud\Enums\Depth;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\ValueObjects\Dav\Resource;
use Illuminate\Support\Collection;

class CalendarsEndpoint extends AbstractDavEndpoint
{
    public function webDavNamespace(): WebDavNamespace
    {
        return WebDavNamespace::Calendars;
    }

    /**
     * @return Collection<Resource>
     */
    public function list(?string $path = null): Collection
    {
        $response = $this->client->withDepth(Depth::One)->propFind($path);

        return collect(WebDavXmlParser::parse($response->body()))->mapInto(Resource::class);
    }
}
