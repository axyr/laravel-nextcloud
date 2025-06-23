<?php

namespace Axyr\Nextcloud\Tests\Api\Core;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class GuestAvatarEndpointTest extends TestCase
{
    public function testGetAvatar(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/avatar.png');

        $content = Nextcloud::core()->guestAvatar()->get('alice', 64);

        $this->assertIsString($content);
        $this->assertSame("\x89PNG", substr($content, 0, 4));
    }

    public function testGetAvatarDark(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/avatar.png');

        $content = Nextcloud::core()->guestAvatar()->getDark('alice', 64);

        $this->assertIsString($content);
        $this->assertSame("\x89PNG", substr($content, 0, 4));
    }
}
