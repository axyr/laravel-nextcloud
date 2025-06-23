<?php

namespace Axyr\Nextcloud\Api\Provisioning;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\GroupId;
use Axyr\Nextcloud\ValueObjects\User;
use Illuminate\Support\Collection;

class UserEndpoint extends AbstractEndpoint
{
    /**
     * @return Collection<User>
     */
    public function list(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/users/details', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }

    /**
     * @return Collection<User>
     */
    public function recent(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/users/recent', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }

    /**
     * @return Collection<GroupId>
     */
    public function subadmins(string $userId): Collection
    {
        $response = $this->apiGet("ocs/v2.php/cloud/users/{$userId}/subadmins");

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data')->map(fn($id) => new GroupId(['id' => $id]));
    }

    public function get(string $id): User
    {
        $response = $this->apiGet("ocs/v2.php/cloud/users/{$id}");

        $this->throwExceptionIfNotOk($response);

        return new User($response->json('ocs.data'));
    }
}
