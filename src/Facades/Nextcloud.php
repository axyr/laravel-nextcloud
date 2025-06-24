<?php

namespace Axyr\Nextcloud\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Axyr\Nextcloud\Api\Dav\DavApi dav())
 * @method static \Axyr\Nextcloud\Api\V2\Apps\AppsApi apps())
 * @method static \Axyr\Nextcloud\Api\V2\Core\CoreApi core())
 * @method static \Axyr\Nextcloud\Api\V2\Files\FilesApi files())
 * @method static \Axyr\Nextcloud\Api\V2\Provisioning\ProvisioningApi provisioning())
 */
class Nextcloud extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nextcloud';
    }
}
