<?php

namespace Axyr\Nextcloud\Config;

use Axyr\Nextcloud\Contracts\ConfigInterface;

readonly class Config implements ConfigInterface
{
    public function __construct(
        private string $baseUrl,
        private string $webDavEntryPoint,
        private string $username,
        private string $password
    ) {}

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getWebDavEntryPoint(): string
    {
        return $this->webDavEntryPoint;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
