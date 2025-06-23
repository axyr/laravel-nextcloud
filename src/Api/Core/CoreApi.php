<?php

namespace Axyr\Nextcloud\Api\Core;

use Axyr\Nextcloud\Api\AbstractApi;

class CoreApi extends AbstractApi
{
    public function status(): StatusEndpoint
    {
        return new StatusEndpoint($this->config);
    }
}
