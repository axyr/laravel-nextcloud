<?php

namespace Axyr\Nextcloud\Api\Endpoints;

use Axyr\Nextcloud\ValueObjects\Folder;
use Illuminate\Support\Collection;

class FolderTreeEndpoint extends Endpoint
{
    /**
     * @return Collection<Folder>
     */
    public function get(array $options = []): Collection
    {
        $response = $this->httpClient()->get($this->getUrl('ocs/v2.php/apps/files/api/v1/folder-tree'), $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect()->mapInto(Folder::class);
    }
}
