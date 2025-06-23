<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Api\Repositories\UserRepository;
use Axyr\Nextcloud\Contracts\ConfigInterface;

readonly class Api
{
    public function __construct(private ConfigInterface $config) { }

    public function config(): ConfigInterface
    {
        return $this->config;
    }

    public function users(): UserRepository
    {
        return new UserRepository($this);
    }
}
