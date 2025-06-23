<?php

namespace Axyr\Nextcloud\Api;

use Axyr\Nextcloud\Contracts\ConfigInterface;

abstract class AbstractApi
{
    public function __construct(protected ConfigInterface $config) {}
}
