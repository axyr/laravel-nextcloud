<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Api\Core\CoreApi;
use Axyr\Nextcloud\Api\Files\FilesApi;
use Axyr\Nextcloud\Api\Provisioning\ProvisioningApi;

class Client
{
    public function core(): CoreApi
    {
        return app(CoreApi::class);
    }

    public function files(): FilesApi
    {
        return app(FilesApi::class);
    }

    public function provisioning(): ProvisioningApi
    {
        return app(ProvisioningApi::class);
    }
}
