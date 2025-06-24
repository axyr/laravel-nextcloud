<?php

namespace Axyr\Nextcloud\Api\V2\Apps;

class AppsApi
{
    public function userStatusEndpoint(): UserStatusEndpoint
    {
        return app(UserStatusEndpoint::class);
    }
}
