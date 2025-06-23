<?php

namespace Axyr\Nextcloud\Api\Provisioning;

use Axyr\Nextcloud\Api\AbstractApi;

class ProvisioningApi extends AbstractApi
{
    public function groups(): GroupEndpoint
    {
        return new GroupEndpoint($this->config);
    }

    public function users(): UserEndpoint
    {
        return new UserEndpoint($this->config);
    }
}
