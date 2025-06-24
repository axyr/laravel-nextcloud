<?php

namespace Axyr\Nextcloud\Api\Dav;

use Axyr\Nextcloud\Clients\WebDavClient;
use Axyr\Nextcloud\Concerns\HandlesNextcloudExceptions;
use Axyr\Nextcloud\Contracts\ConfigInterface;
use Axyr\Nextcloud\Enums\WebDavNamespace;

abstract class AbstractDavEndpoint
{
    use HandlesNextcloudExceptions;

    public function __construct(
        protected ConfigInterface $config,
        protected readonly WebDavClient $client
    ) {
        $this->client->forNamespace($this->webDavNamespace());
    }

    abstract public function webDavNamespace(): WebDavNamespace;
}
