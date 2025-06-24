<?php

namespace Axyr\Nextcloud\Api\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\HoverCard;

class HoverCardEndpoint extends AbstractEndpoint
{
    public function get(string $userId, array $options = []): HoverCard
    {
        $response = $this->apiGet("ocs/v2.php/hovercard/v1/{$userId}", $options);

        $this->throwExceptionIfNotOk($response);

        return new HoverCard($response->json('ocs.data'));
    }
}
