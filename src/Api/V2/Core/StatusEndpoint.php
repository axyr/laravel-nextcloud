<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\Status;

class StatusEndpoint extends AbstractEndpoint
{
    public function get(array $options = []): Status
    {
        $response = $this->http->get('status.php', $options);

        $this->throwExceptionIfNotOk($response);

        return new Status($response->json());
    }
}
