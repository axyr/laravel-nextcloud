<?php

namespace Axyr\Nextcloud\Api\V2\Provisioning;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\Group;
use Axyr\Nextcloud\ValueObjects\GroupId;
use Axyr\Nextcloud\ValueObjects\User;
use Axyr\Nextcloud\ValueObjects\UserId;
use Illuminate\Support\Collection;

class GroupEndpoint extends AbstractEndpoint
{
    /**
     * @return Collection<UserId>
     */
    public function subadmins(string $groupId): Collection
    {
        $response = $this->apiGet("ocs/v2.php/cloud/groups/{$groupId}/subadmins");

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data')->map(fn(string $id) => new UserId(['id' => $id]));
    }

    public function create(array $data): bool
    {
        $response = $this->apiPost('ocs/v2.php/cloud/groups', $data);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    /**
     * @return Collection<GroupId>
     */
    public function list(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/groups', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.groups')->map(fn(string $id) => new GroupId(['id' => $id]));
    }

    /**
     * @return Collection<Group>
     */
    public function listDetails(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/groups/details', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.groups')->mapInto(Group::class);
    }

    public function update(string $groupId, string $displayname): bool
    {
        $response = $this->apiPut("ocs/v2.php/cloud/groups/{$groupId}", [
            'key' => 'displayname',
            'value' => $displayname,
        ]);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function delete(string $groupId): bool
    {
        $response = $this->apiDelete("ocs/v2.php/cloud/groups/{$groupId}");

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    /**
     * @return Collection<UserId>
     */
    public function users(string $groupId): Collection
    {
        $response = $this->apiGet("ocs/v2.php/cloud/groups/{$groupId}/users");

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->map(fn(string $id) => new UserId(['id' => $id]));
    }

    /**
     * @return Collection<User>
     */
    public function userDetails(string $groupId): Collection
    {
        $response = $this->apiGet("ocs/v2.php/cloud/groups/{$groupId}/users/details");

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }
}
