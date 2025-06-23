<?php

namespace Axyr\Nextcloud\Tests\Api\Endpoints;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\Group;
use Axyr\Nextcloud\ValueObjects\User;

class UserEndpointTest extends TestCase
{
    public function testGetUsers(): void
    {
        $this->fakeHttpResponse('fixtures/api/endpoints/user-endpoint/users.json');

        $users = Nextcloud::api()->users()->get();

        $this->assertCount(12, $users);
        $this->assertInstanceOf(User::class, $users->first());
    }

    public function testGetRecentUsers(): void
    {
        $this->fakeHttpResponse('fixtures/api/endpoints/user-endpoint/recent.json');

        $users = Nextcloud::api()->users()->recent();

        $this->assertCount(1, $users);
        $this->assertInstanceOf(User::class, $users->first());
        $this->assertEquals('admin', $users->first()->id());
    }

    public function testGetSubadmins(): void
    {
        $this->fakeHttpResponse('fixtures/api/endpoints/user-endpoint/subadmins.json');

        $groups = Nextcloud::api()->users()->subadmins('alice');

        $this->assertInstanceOf(Group::class, $groups->first());
        $this->assertEquals('GroupA', $groups->first()->name());
    }

    public function testGetUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/endpoints/user-endpoint/user.json');

        $user = Nextcloud::api()->users()->find('admin');

        $this->assertTrue($user->enabled());
        $this->assertEquals('admin', $user->id());
        $this->assertEquals('admin@example.net', $user->email());

        $this->assertEquals(-3, $user->quota()->free());
        $this->assertEquals(20575003, $user->quota()->used());
    }
}
