<?php

namespace Axyr\Nextcloud\Tests\Api\Dav;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class CalendarsEndpointTest extends TestCase
{
    public function testGetInfiniteCalendars(): void
    {
        $this->fakeHttpResponse('fixtures/dav/calendars.xml');

        $resources = Nextcloud::dav()->calendars()->list();

        $this->assertCount(8, $resources);
        $this->assertEquals('/remote.php/dav/calendars/admin/', $resources->first()->path());
        $this->assertEquals('/remote.php/dav/calendars/admin/huisvuilkalenderdenhaagnl/', $resources->last()->path());
    }
}
