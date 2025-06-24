<?php

namespace Axyr\Nextcloud\Api\V2;

use Axyr\Nextcloud\Clients\HttpClient;
use Axyr\Nextcloud\Concerns\HandlesNextcloudExceptions;
use Axyr\Nextcloud\Contracts\ConfigInterface;

abstract class AbstractHttpEndpoint
{
    use HandlesNextcloudExceptions;

    public function __construct(
        protected ConfigInterface $config,
        protected readonly HttpClient $client
    ) {}
}
