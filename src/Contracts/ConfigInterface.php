<?php

namespace Axyr\Nextcloud\Contracts;

interface ConfigInterface
{
    public function getBaseUrl(): string;

    public function getUsername(): string;

    public function getPassword(): string;

    public function getDefaultHeaders(): array;
}
