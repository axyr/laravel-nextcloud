<?php

namespace Axyr\Nextcloud\Api\Files;

class FilesApi
{
    public function folderTree(): FolderTreeEndpoint
    {
        return app(FolderTreeEndpoint::class);
    }
}
