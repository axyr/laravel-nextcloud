<?php

namespace Axyr\Nextcloud\Api\Provisioning;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\Requests\UserCreateRequest;
use Axyr\Nextcloud\ValueObjects\AppId;
use Axyr\Nextcloud\ValueObjects\Field;
use Axyr\Nextcloud\ValueObjects\GroupId;
use Axyr\Nextcloud\ValueObjects\User;
use Axyr\Nextcloud\ValueObjects\UserId;
use Illuminate\Support\Collection;

class UserEndpoint extends AbstractEndpoint
{
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

    public function addSubadminToGroup(string $userId, string $groupId): bool
    {
        $response = $this->apiPost("ocs/v2.php/cloud/users/{$userId}/subadmins", [
            'groupid' => $groupId,
        ]);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function removeSubadminFromGroup(string $userId, string $groupId): bool
    {
        $response = $this->apiDelete("ocs/v2.php/cloud/users/{$userId}/subadmins", [
            'groupid' => $groupId,
        ]);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    /**
     * @return Collection<UserId>
     */
    public function list(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/users', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->map(fn($id) => new UserId(['id' => $id]));
    }

    public function create(UserCreateRequest $request): UserId
    {
        $response = $this->apiPost('ocs/v2.php/cloud/users', $request->toArray());

        $this->throwExceptionIfNotOk($response);

        return new UserId($response->json('ocs.data'));
    }

    /**
     * @return Collection<User>
     */
    public function listDetails(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/users/details', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }

    /**
     * @return Collection<User>
     */
    public function listDisabledDetails(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/users/disabled', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }

    public function searchByPhone(string $location, array $search): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/users/search/by-phone', [
            'location' => $location,
            'search' => $search,
        ]);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }

    public function get(?string $id = null): User
    {
        $response = $id ? $this->apiGet("ocs/v2.php/cloud/users/{$id}") : $this->apiGet("ocs/v2.php/cloud/user");

        $this->throwExceptionIfNotOk($response);

        return new User($response->json('ocs.data'));
    }

    public function fields(?string $id = null): Collection
    {
        $response = $id ? $this->apiGet("ocs/v2.php/cloud/user/fields/{$id}") : $this->apiGet("ocs/v2.php/cloud/user/fields");

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data')->map(fn($name) => new Field(['name' => $name]));
    }

    public function apps(): Collection
    {
        $response = $this->apiGet("ocs/v2.php/cloud/user/apps");
        
        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.apps')->map(fn($id) => new AppId(['id' => $id]));
    }

    public function update(string $id, string $key, mixed $value): bool
    {
        $response = $this->apiPut("ocs/v2.php/cloud/users/{$id}", [
            'key' => $key,
            'value' => $value,
        ]);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function delete(string $id): bool
    {
        $response = $this->apiDelete("ocs/v2.php/cloud/users/{$id}");

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function enable(string $id): bool
    {
        $response = $this->apiPut("ocs/v2.php/cloud/users/{$id}/enable");

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function disable(string $id): bool
    {
        $response = $this->apiPut("ocs/v2.php/cloud/users/{$id}/disable");

        $this->throwExceptionIfNotOk($response);

        return true;
    }
}
