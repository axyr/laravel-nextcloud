<?php

namespace Axyr\Nextcloud\Api\V2\Files;

use Axyr\Nextcloud\Api\V2\AbstractHttpEndpoint;
use Axyr\Nextcloud\ValueObjects\Folder;
use Illuminate\Support\Collection;

class FolderTreeEndpoint extends AbstractHttpEndpoint
{
    /**
     * @return Collection<Folder>
     */
    public function list(array $options = []): Collection
    {
        $response = $this->client->get('ocs/v2.php/apps/files/api/v1/folder-tree', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect()->mapInto(Folder::class);
    }
}
