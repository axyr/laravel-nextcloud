<?php

namespace Axyr\Nextcloud\Api\Endpoints;

use Axyr\Nextcloud\ValueObjects\Group;
use Illuminate\Support\Collection;

class GroupEndpoint extends Endpoint
{
    /**
     * @return Collection<Group>
     */
    public function get(array $options = []): Collection
    {
        $response = $this->httpClient()->get($this->getUrl('ocs/v2.php/cloud/groups'), $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.groups')->map(fn($name) => new Group(['name' => $name]));
    }
}
