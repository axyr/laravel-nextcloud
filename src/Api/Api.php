<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Api\Endpoints\FolderTreeEndpoint;
use Axyr\Nextcloud\Api\Endpoints\GroupEndpoint;
use Axyr\Nextcloud\Api\Endpoints\StatusEndpoint;
use Axyr\Nextcloud\Api\Endpoints\UserEndpoint;
use Axyr\Nextcloud\Contracts\ConfigInterface;

readonly class Api
{
    public function __construct(private ConfigInterface $config) {}

    public function config(): ConfigInterface
    {
        return $this->config;
    }

    public function groups(): GroupEndpoint
    {
        return new GroupEndpoint($this);
    }

    public function users(): UserEndpoint
    {
        return new UserEndpoint($this);
    }

    public function folderTree(): FolderTreeEndpoint
    {
        return new FolderTreeEndpoint($this);
    }

    public function status(): StatusEndpoint
    {
        return new StatusEndpoint($this);
    }
}
