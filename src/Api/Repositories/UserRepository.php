<?php

namespace Axyr\Nextcloud\Api\Repositories;

use Axyr\Nextcloud\Exception\NextCloudApiException;
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

        if ($response->ok()) {
            return $response->collect('ocs.data.users')->mapInto(User::class);
        }

        throw new NextCloudApiException($response->getReasonPhrase(), $response->getStatusCode());
    }

    public function find(string $id): User
    {
        $response = $this->httpClient()->get($this->getUrl("ocs/v2.php/cloud/users/{$id}"));

        if ($response->ok()) {
            return new User($response->json('ocs.data'));
        }

        throw new NextCloudApiException($response->getReasonPhrase(), $response->getStatusCode());
    }

}
