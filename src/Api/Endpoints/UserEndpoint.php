<?php

namespace Axyr\Nextcloud\Api\Endpoints;

use Axyr\Nextcloud\ValueObjects\Group;
use Axyr\Nextcloud\ValueObjects\User;
use Illuminate\Support\Collection;

class UserEndpoint extends Endpoint
{
    /**
     * @return Collection<User>
     */
    public function get(array $options = []): Collection
    {
        $response = $this->httpClient()->get($this->getUrl('ocs/v2.php/cloud/users/details'), $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }

    /**
     * @return Collection<User>
     */
    public function recent(array $options = []): Collection
    {
        $response = $this->httpClient()->get($this->getUrl('ocs/v2.php/cloud/users/recent'), $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }

    /**
     * @return Collection<Group>
     */
    public function subadmins(string $userId): Collection
    {
        $response = $this->httpClient()->get($this->getUrl("ocs/v2.php/cloud/users/{$userId}/subadmins"));

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data')->map(fn($name) => new Group(['name' => $name]));
    }

    public function find(string $id): User
    {
        $response = $this->httpClient()->get($this->getUrl("ocs/v2.php/cloud/users/{$id}"));

        $this->throwExceptionIfNotOk($response);

        return new User($response->json('ocs.data'));
    }
}
