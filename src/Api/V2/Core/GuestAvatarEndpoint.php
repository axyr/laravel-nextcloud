<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\V2\AbstractHttpEndpoint;

class GuestAvatarEndpoint extends AbstractHttpEndpoint
{
    public function get(string $guestName, int $size, array $options = []): string
    {
        $response = $this->client->get("/index.php/avatar/guest/{$guestName}/{$size}", $options);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }

    public function getDark(string $guestName, int $size, array $options = []): string
    {
        $response = $this->client->get("/index.php/avatar/guest/{$guestName}/{$size}/dark", $options);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }
}
