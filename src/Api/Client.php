<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Api\Core\CoreApi;
use Axyr\Nextcloud\Api\Files\FilesApi;
use Axyr\Nextcloud\Api\Provisioning\ProvisioningApi;
use Axyr\Nextcloud\Contracts\ConfigInterface;

readonly class Client
{
    public function __construct(private ConfigInterface $config) {}

    public function core(): CoreApi
    {
        return new CoreApi($this->config);
    }

    public function files(): FilesApi
    {
        return new FilesApi($this->config);
    }

    public function provisioning(): ProvisioningApi
    {
        return new ProvisioningApi($this->config);
    }
}
