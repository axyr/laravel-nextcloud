<?php

namespace Axyr\Nextcloud\Api\V2\Files;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\Folder;
use Illuminate\Support\Collection;

class FolderTreeEndpoint extends AbstractEndpoint
{
    /**
     * @return Collection<Folder>
     */
    public function list(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/apps/files/api/v1/folder-tree', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect()->mapInto(Folder::class);
    }
}
