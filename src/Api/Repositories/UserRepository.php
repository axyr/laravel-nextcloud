<?php

namespace Axyr\Nextcloud\Api\Repositories;

use Axyr\Nextcloud\ValueObjects\User;
use Illuminate\Support\Collection;

class UserRepository extends Repository
{
    /**
     * @return \Illuminate\Support\Collection<User>
     */
    public function get(array $options = []): Collection
    {
        $response = $this->httpClient()->get($this->getUrl('ocs/v2.php/cloud/users/details'), $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.users')->mapInto(User::class);
    }

    public function find(string $id): User
    {
        $response = $this->httpClient()->get($this->getUrl("ocs/v2.php/cloud/users/{$id}"));

        $this->throwExceptionIfNotOk($response);

        return new User($response->json('ocs.data'));
    }
}
