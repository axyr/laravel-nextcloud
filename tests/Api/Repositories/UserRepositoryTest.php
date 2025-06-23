<?php

namespace Axyr\Nextcloud\Tests\Api\Repositories;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\User;

class UserRepositoryTest extends TestCase
{
    public function testGetUsers(): void
    {
        $this->fakeHttpResponse('fixtures/api/repositories/user-repository/users.json');

        $users = Nextcloud::api()->users()->get();

        $this->assertCount(12, $users);
        $this->assertInstanceOf(User::class, $users->first());
    }

    public function testGetUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/repositories/user-repository/user.json');

        $user = Nextcloud::api()->users()->find('admin');

        $this->assertTrue($user->enabled());
        $this->assertEquals('admin', $user->id());
        $this->assertEquals('admin@example.net', $user->email());

        $this->assertEquals(-3, $user->quota()->free());
        $this->assertEquals(20575003, $user->quota()->used());
    }
}
