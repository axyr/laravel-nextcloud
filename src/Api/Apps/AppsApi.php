<?php

namespace Axyr\Nextcloud\Api\Apps;

class AppsApi
{
    public function userStatusEndpoint(): UserStatusEndpoint
    {
        return app(UserStatusEndpoint::class);
    }
}
