<?php

namespace Axyr\Nextcloud\Tests\Api\Core;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\Capability;

class CapabilitiesEndpointTest extends TestCase
{
    public function testGetCapabilities(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/capabilities.json');

        $result = Nextcloud::core()->capabilities()->list();

        $this->assertEquals('32.0.0 dev', $result->version()->string());

        /** @var Capability $files */
        $files = $result->list()->firstWhere(fn(Capability $c) => $c->capability() === 'files');

        $this->assertInstanceOf(Capability::class, $files);
        $this->assertTrue($files->attributes()['bigfilechunking']);
    }
}
