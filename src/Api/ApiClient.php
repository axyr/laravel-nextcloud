<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Api\Dav\DavApi;
use Axyr\Nextcloud\Api\V2\Apps\AppsApi;
use Axyr\Nextcloud\Api\V2\Core\CoreApi;
use Axyr\Nextcloud\Api\V2\Files\FilesApi;
use Axyr\Nextcloud\Api\V2\Provisioning\ProvisioningApi;

class ApiClient
{
    public function apps(): AppsApi
    {
        return app(AppsApi::class);
    }

    public function core(): CoreApi
    {
        return app(CoreApi::class);
    }

    public function dav(): DavApi
    {
        return app(DavApi::class);
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
