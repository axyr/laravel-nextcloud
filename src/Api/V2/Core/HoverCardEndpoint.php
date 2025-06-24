<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\V2\AbstractHttpEndpoint;
use Axyr\Nextcloud\ValueObjects\HoverCard;

class HoverCardEndpoint extends AbstractHttpEndpoint
{
    public function get(string $userId, array $options = []): HoverCard
    {
        $response = $this->client->get("ocs/v2.php/hovercard/v1/{$userId}", $options);

        $this->throwExceptionIfNotOk($response);

        return new HoverCard($response->json('ocs.data'));
    }
}
