<?php

namespace Axyr\Nextcloud\Api\V2\Files;

class FilesApi
{
    public function folderTree(): FolderTreeEndpoint
    {
        return app(FolderTreeEndpoint::class);
    }
}
