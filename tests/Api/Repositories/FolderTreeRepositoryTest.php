<?php

namespace Axyr\Nextcloud\Tests\Api\Repositories;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\Folder;

class FolderTreeRepositoryTest extends TestCase
{
    public function testGetFolders(): void
    {
        $this->fakeHttpResponse('fixtures/api/repositories/folder-repository/folders.json');

        $folders = Nextcloud::api()->folderTree()->get([
            'depth' => 10,
        ]);

        $this->assertCount(2, $folders);
        $this->assertInstanceOf(Folder::class, $folders->first());
        $this->assertEquals(4, $folders->first()->id());
        $this->assertEquals('Media', $folders->first()->basename());
        $this->assertCount(2, $folders->first()->children());
        $this->assertEquals('Office', $folders->first()->children()->first()->basename());
        $this->assertCount(1, $folders->first()->children()->first()->children());
        $this->assertEquals('Word', $folders->first()->children()->first()->children()->first()->basename());
    }
}
