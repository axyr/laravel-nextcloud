<?php

namespace Axyr\Nextcloud\Api\Provisioning;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\Group;
use Axyr\Nextcloud\ValueObjects\User;
use Illuminate\Support\Collection;

class GroupEndpoint extends AbstractEndpoint
{
    /**
     * @return Collection<Group>
     */
    public function list(array $options = []): Collection
    {
        $response = $this->httpClient()->get($this->getUrl('ocs/v2.php/cloud/groups'), $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.groups')->map(fn($name) => new Group(['name' => $name]));
    }

    /**
     * @return Collection<User>
     */
    public function subadmins(string $groupId): Collection
    {
        $response = $this->httpClient()->get($this->getUrl("ocs/v2.php/cloud/groups/{$groupId}/subadmins"));

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data')->map(fn($id) => new User(['id' => $id]));
    }

    /**
     * @return Collection<User>
     */
    public function users(string $groupId): Collection
    {
        $response = $this->httpClient()->get($this->getUrl("ocs/v2.php/cloud/groups/{$groupId}"));

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data')->map(fn($id) => new User(['id' => $id]));
    }
}
