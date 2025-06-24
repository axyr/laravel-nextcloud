<?php

namespace Axyr\Nextcloud\Tests\Api\Dav;

use Axyr\Nextcloud\Enums\Overwrite;
use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class TrashbinEndpointTest extends TestCase
{
    public function testGetInfiniteItems(): void
    {
        $this->fakeHttpResponse('fixtures/dav/trashbin.xml');

        $resources = Nextcloud::dav()->trashbin()->list();

        $this->assertCount(9, $resources);
        $this->assertEquals('/remote.php/dav/trashbin/admin/trash/', $resources->first()->path());
        $this->assertEquals('/remote.php/dav/trashbin/admin/trash/Testssssssss.d1750794735/', $resources->last()->path());
    }

    public function testRestore(): void
    {
        $this->fakeHttpResponse('fixtures/dav/empty-response.txt');

        $path = '/remote.php/dav/trashbin/admin/trash/Testssssssss.d1750794735';

        $result = Nextcloud::dav()->trashbin()->restore($path, Overwrite::Yes);

        $this->assertTrue($result);
    }

    public function testDelete(): void
    {
        $this->fakeHttpResponse('fixtures/dav/empty-response.txt');

        $path = '/remote.php/dav/trashbin/admin/trash/TestC.d1750798245';

        $result = Nextcloud::dav()->trashbin()->delete($path);

        $this->assertTrue($result);
    }

    public function testEmpty(): void
    {
        $this->fakeHttpResponse('fixtures/dav/empty-response.txt');

        $result = Nextcloud::dav()->trashbin()->empty();

        $this->assertTrue($result);
    }
}
