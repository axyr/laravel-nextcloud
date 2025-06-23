<?php

namespace Axyr\Nextcloud\Api\Endpoints;

use Axyr\Nextcloud\ValueObjects\Status;

class StatusEndpoint extends Endpoint
{
    public function get(array $options = []): Status
    {
        $response = $this->httpClient()->get($this->getUrl('status.php'), $options);

        $this->throwExceptionIfNotOk($response);

        return new Status($response->json());
    }
}
