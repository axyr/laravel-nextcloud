<?php

namespace Axyr\Nextcloud\Api\Dav;

class DavApi
{
    public function folders(): FoldersEndpoint
    {
        return app(FoldersEndpoint::class);
    }
}
