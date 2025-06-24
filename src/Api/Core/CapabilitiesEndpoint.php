<?php

namespace Axyr\Nextcloud\Api\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\Capabilities;

class CapabilitiesEndpoint extends AbstractEndpoint
{
    public function list(array $options = []): Capabilities
    {
        $response = $this->apiGet('/ocs/v2.php/cloud/capabilities', $options);

        $this->throwExceptionIfNotOk($response);

        return new Capabilities($response->json('ocs.data'));
    }
}
