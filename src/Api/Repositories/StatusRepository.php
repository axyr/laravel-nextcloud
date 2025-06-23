<?php

namespace Axyr\Nextcloud\Api\Repositories;

use Axyr\Nextcloud\ValueObjects\Status;

class StatusRepository extends Repository
{
    public function get(array $options = []): Status
    {
        $response = $this->httpClient()->get($this->getUrl('status.php'), $options);

        $this->throwExceptionIfNotOk($response);

        return new Status($response->json());
    }
}
