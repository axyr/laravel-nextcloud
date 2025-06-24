<?php

namespace Axyr\Nextcloud\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Axyr\Nextcloud\Api\Core\CoreApi core())
 * @method static \Axyr\Nextcloud\Api\Apps\AppsApi apps())
 * @method static \Axyr\Nextcloud\Api\Files\FilesApi files())
 * @method static \Axyr\Nextcloud\Api\Provisioning\ProvisioningApi provisioning())
 */
class Nextcloud extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nextcloud';
    }
}
