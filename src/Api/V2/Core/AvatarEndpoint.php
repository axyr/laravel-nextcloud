<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;

class AvatarEndpoint extends AbstractEndpoint
{
    public function get(string $userId, int $size, array $options = []): string
    {
        $response = $this->http->get("/index.php/avatar/{$userId}/{$size}", $options);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }

    public function getDark(string $userId, int $size, array $options = []): string
    {
        $response = $this->http->get("/index.php/avatar/{$userId}/{$size}/dark", $options);

        $this->throwExceptionIfNotOk($response);

        return $response->body();
    }
}
