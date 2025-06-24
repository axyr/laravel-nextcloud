<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\V2\AbstractHttpEndpoint;
use Axyr\Nextcloud\ValueObjects\Capabilities;

class CapabilitiesEndpoint extends AbstractHttpEndpoint
{
    public function list(array $options = []): Capabilities
    {
        $response = $this->client->get('/ocs/v2.php/cloud/capabilities', $options);

        $this->throwExceptionIfNotOk($response);

        return new Capabilities($response->json('ocs.data'));
    }
}
