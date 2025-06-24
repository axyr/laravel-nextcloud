<?php

namespace Axyr\Nextcloud\Tests\Api\Dav;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class NamespacesEndpointTest extends TestCase
{
    public function testNamespaces(): void
    {
        $this->fakeHttpResponse('fixtures/dav/namespaces.xml');

        $resources = Nextcloud::dav()->namespaces()->list();

        $this->assertCount(16, $resources);
        $this->assertEquals('/remote.php/dav/', $resources->first()->path());
        $this->assertEquals('/remote.php/dav/versions/', $resources->last()->path());
    }
}
