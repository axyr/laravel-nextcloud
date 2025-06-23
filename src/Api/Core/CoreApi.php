<?php

namespace Axyr\Nextcloud\Api\Core;

class CoreApi
{
    public function status(): StatusEndpoint
    {
        return app(StatusEndpoint::class);
    }
}
