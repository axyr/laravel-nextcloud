<?php

namespace Axyr\Nextcloud\Tests\Api\Dav;

use Axyr\Nextcloud\Enums\Overwrite;
use Axyr\Nextcloud\Exception\NextCloudApiException;
use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class FilesEndpointTest extends TestCase
{
    public function testGetInfiniteFolders(): void
    {
        $this->fakeHttpResponse('fixtures/dav/folders-infinite.xml');

        $resources = Nextcloud::dav()->files()->list();

        $this->assertCount(17, $resources);
        $this->assertEquals('/remote.php/dav/files/admin/', $resources->first()->path());
        $this->assertEquals('/remote.php/dav/files/admin/Templates/Template.docx', $resources->last()->path());
    }

    public function testDownloadFile(): void
    {
        $this->fakeHttpResponse('fixtures/dav/Screenshot 2025-06-20 at 13.49.08.png');

        $path = '/remote.php/dav/files/admin/Media/Office/Screenshot%202025-06-20%20at%2013.49.08.png';
        $content = Nextcloud::dav()->files()->downloadFile($path);

        $this->assertIsString($content);
        $this->assertSame("\x89PNG", substr($content, 0, 4));
    }

    public function testDownloadFolder(): void
    {
        $this->fakeHttpResponse('fixtures/dav/Office.zip');

        $path = '/remote.php/dav/files/admin/Media/Office';
        $content = Nextcloud::dav()->files()->downloadFolder($path);

        $this->assertIsString($content);
        $this->assertSame("PK", substr($content, 0, 2));
    }

    public function testCreateFolder(): void
    {
        $this->fakeHttpResponse('fixtures/dav/empty-response.txt');

        $result = Nextcloud::dav()->files()->createFolder('/Test');

        $this->assertTrue($result);
    }

    public function testCreateFolderFails(): void
    {
        $this->expectException(NextCloudApiException::class);
        $this->expectExceptionCode(405);
        $this->expectExceptionMessage('Parent node does not exist');

        $this->fakeHttpResponse('fixtures/dav/parent-node-does-not-exists.xml', 405);

        Nextcloud::dav()->files()->createFolder('/Test');
    }

    public function testDelete(): void
    {
        $this->fakeHttpResponse('fixtures/dav/empty-response.txt');

        $result = Nextcloud::dav()->files()->delete('/Test');

        $this->assertTrue($result);
    }

    public function testMove(): void
    {
        $this->fakeHttpResponse('fixtures/dav/empty-response.txt');

        $result = Nextcloud::dav()->files()->move('/TestA', '/TestB/TestC', OverWrite::Yes);

        $this->assertTrue($result);
    }

    public function testCopy(): void
    {
        $this->fakeHttpResponse('fixtures/dav/empty-response.txt');

        $result = Nextcloud::dav()->files()->copy('/TestA', '/TestB/TestC', OverWrite::Yes);

        $this->assertTrue($result);
    }

}
