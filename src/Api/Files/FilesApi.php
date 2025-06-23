<?php

namespace Axyr\Nextcloud\Api\Files;

use Axyr\Nextcloud\Api\AbstractApi;

class FilesApi extends AbstractApi
{
    public function folderTree(): FolderTreeEndpoint
    {
        return new FolderTreeEndpoint($this->config);
    }
}
