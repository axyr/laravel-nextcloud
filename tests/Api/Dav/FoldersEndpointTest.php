<?php

namespace Axyr\Nextcloud\Tests\Api\Dav;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class FoldersEndpointTest extends TestCase
{
    public function testGetInfiniteFolders(): void
    {
        $this->fakeHttpResponse('fixtures/dav/folders-infinite.xml');

        $resources = Nextcloud::dav()->folders()->list();

        $this->assertCount(17, $resources);
        $this->assertEquals('/remote.php/dav/files/admin/', $resources->first()->path());
        $this->assertEquals('/remote.php/dav/files/admin/Templates/Template.docx', $resources->last()->path());
    }
}
