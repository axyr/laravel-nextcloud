<?php

namespace Axyr\Nextcloud\Api\Repositories;

use Axyr\Nextcloud\Exception\NextCloudApiException;
use Axyr\Nextcloud\ValueObjects\Status;

class StatusRepository extends Repository
{
    public function get(array $options = []): Status
    {
        $response = $this->httpClient()->get($this->getUrl('status.php'), $options);

        if ($response->ok()) {
            return new Status($response->json());
        }

        throw new NextCloudApiException($response->getReasonPhrase(), $response->getStatusCode());
    }
}
