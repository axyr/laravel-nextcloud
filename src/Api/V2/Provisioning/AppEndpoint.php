<?php

namespace Axyr\Nextcloud\Api\V2\Provisioning;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\App;
use Axyr\Nextcloud\ValueObjects\AppId;
use Illuminate\Support\Collection;

class AppEndpoint extends AbstractEndpoint
{
    /**
     * @return Collection<AppId>
     */
    public function list(array $options = []): Collection
    {
        $response = $this->apiGet('ocs/v2.php/cloud/apps', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data.apps')->map(fn(string $id) => new AppId(['id' => $id]));
    }

    public function get(string $id): App
    {
        $response = $this->apiGet("ocs/v2.php/cloud/apps/{$id}");

        $this->throwExceptionIfNotOk($response);

        return new App($response->json('ocs.data'));
    }

    public function enable(string $id): bool
    {
        $response = $this->apiPost("ocs/v2.php/cloud/apps/{$id}");

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function disable(string $id): bool
    {
        $response = $this->apiDelete("ocs/v2.php/cloud/apps/{$id}");

        $this->throwExceptionIfNotOk($response);

        return true;
    }
}
