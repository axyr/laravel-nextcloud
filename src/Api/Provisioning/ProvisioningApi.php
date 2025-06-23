<?php

namespace Axyr\Nextcloud\Api\Provisioning;

class ProvisioningApi
{
    public function apps(): AppEndpoint
    {
        return app(AppEndpoint::class);
    }

    public function groups(): GroupEndpoint
    {
        return app(GroupEndpoint::class);
    }

    public function users(): UserEndpoint
    {
        return app(UserEndpoint::class);
    }
}
