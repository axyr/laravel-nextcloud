<?php

namespace Axyr\Nextcloud\Tests\Api\V2\Provisioning;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\AppId;

class AppEndpointTest extends TestCase
{
    public function testListApps(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/app-endpoint/apps.json');

        $apps = Nextcloud::provisioning()->apps()->list();

        $this->assertCount(26, $apps);
        $this->assertInstanceOf(AppId::class, $apps->first());
        $this->assertEquals('encryption', $apps->first()->id());
        $this->assertEquals('user_oidc', $apps->last()->id());
    }

    public function testGetApp(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/app-endpoint/files-sharing.json');

        $app = Nextcloud::provisioning()->apps()->get('files_sharing');

        $this->assertEquals('files_sharing', $app->id());
        $this->assertEquals([
            'Michael Gapczynski',
            'Bjoern Schiessle',
        ], $app->authors()->toArray());
    }

    public function testEnableApp(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->apps()->enable('files_sharing');

        $this->assertTrue($result);
    }

    public function testDisableApp(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->apps()->disable('files_sharing');

        $this->assertTrue($result);
    }
}
