<?php

namespace Axyr\Nextcloud\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Axyr\Nextcloud\Api\Api api())
 */
class Nextcloud extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nextcloud';
    }
}
