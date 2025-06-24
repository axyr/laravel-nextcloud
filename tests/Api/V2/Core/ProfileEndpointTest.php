<?php

namespace Axyr\Nextcloud\Tests\Api\V2\Core;

use Axyr\Nextcloud\Enums\ProfileFieldVisibility;
use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class ProfileEndpointTest extends TestCase
{
    public function testGetProfileFields(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/profile-fields.json');

        $result = Nextcloud::core()->profile()->list('admin');

        $this->assertEquals('admin', $result->userId());
        $this->assertEquals('admin', $result->displayName());
        $this->assertEquals('Europe/Amsterdam', $result->timezone());
        $this->assertEquals(7200, $result->timezoneOffset());
        $this->assertTrue($result->isUserAvatarVisible());

        $actions = $result->actions();
        $this->assertCount(2, $actions);
        $this->assertEquals('email', $actions[0]->id());
        $this->assertEquals('phone', $actions[1]->id());

        $custom = $result->customAttributes();
        $this->assertArrayHasKey('address', $custom);
        $this->assertEquals('Den Haag', $custom['address']);
    }

    public function testSetProfileFieldVisibility(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::core()->profile()->setVisibility('admin', 'role', ProfileFieldVisibility::Hide);

        $this->assertTrue($result);
    }
}
