<?php

namespace Axyr\Nextcloud\Api\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;

class GuestAvatarEndpoint extends AbstractEndpoint
{
    public function get(string $guestName, int $size, array $options = []): string
    {
        $response = $this->apiGet("/index.php/avatar/guest/{$guestName}/{$size}", $options);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }

    public function getDark(string $guestName, int $size, array $options = []): string
    {
        $response = $this->apiGet("/index.php/avatar/guest/{$guestName}/{$size}/dark", $options);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }
}
