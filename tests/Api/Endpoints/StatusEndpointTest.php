<?php

namespace Axyr\Nextcloud\Tests\Api\Endpoints;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class StatusEndpointTest extends TestCase
{
    public function testGetStatus(): void
    {
        $this->fakeHttpResponse('fixtures/api/endpoints/status-endpoint/status.json');

        $status = Nextcloud::api()->status()->get();

        $this->assertTrue($status->installed());
        $this->assertFalse($status->maintenance());
        $this->assertFalse($status->needsDbUpgrade());
        $this->assertEquals('32.0.0.0', $status->version());
        $this->assertEquals('32.0.0 dev', $status->versionString());
        $this->assertEquals('fake', $status->edition());
        $this->assertEquals('Nextcloud', $status->productname());
        $this->assertTrue($status->extendedSupport());
    }
}
