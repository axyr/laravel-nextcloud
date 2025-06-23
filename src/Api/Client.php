<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Contracts\ConfigInterface;

readonly class Client
{
    public function __construct(private ConfigInterface $config) { }

    public function api(): Api
    {
        return new Api($this->config);
    }
}
