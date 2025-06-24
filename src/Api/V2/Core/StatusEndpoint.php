<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\V2\AbstractHttpEndpoint;
use Axyr\Nextcloud\ValueObjects\Status;

class StatusEndpoint extends AbstractHttpEndpoint
{
    public function get(array $options = []): Status
    {
        $response = $this->client->get('status.php', $options);

        $this->throwExceptionIfNotOk($response);

        return new Status($response->json());
    }
}
