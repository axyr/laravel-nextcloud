<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\Enums\ProfileFieldVisibility;
use Axyr\Nextcloud\ValueObjects\ProfileFields;

class ProfileEndpoint extends AbstractEndpoint
{
    public function list(string $userId, array $options = []): ProfileFields
    {
        $response = $this->apiGet("/ocs/v2.php/profile/{$userId}", $options);

        $this->throwExceptionIfNotOk($response);

        return new ProfileFields($response->json('ocs.data'));
    }

    public function setVisibility(string $userId, string $field, ProfileFieldVisibility $visibility): bool
    {
        $response = $this->apiPut("/ocs/v2.php/profile/{$userId}", [
            'paramId' => $field,
            'visibility' => $visibility->value,
        ]);

        $this->throwExceptionIfNotOk($response);

        return true;
    }
}
