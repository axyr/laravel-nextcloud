<?php

namespace Axyr\Nextcloud\Tests\Api\Provisioning;

use Axyr\Nextcloud\Exception\NextCloudApiException;
use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Requests\UserCreateRequest;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\GroupId;
use Axyr\Nextcloud\ValueObjects\User;
use Axyr\Nextcloud\ValueObjects\UserId;

class UserEndpointTest extends TestCase
{
    public function testGetRecentUsers(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/recent.json');

        $users = Nextcloud::provisioning()->users()->recent();

        $this->assertCount(1, $users);
        $this->assertInstanceOf(User::class, $users->first());
        $this->assertEquals('admin', $users->first()->id());
    }

    public function testGetSubadmins(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/subadmins.json');

        $groups = Nextcloud::provisioning()->users()->subadmins('alice');

        $this->assertInstanceOf(GroupId::class, $groups->first());
        $this->assertEquals('GroupA', $groups->first()->id());
    }

    public function testAddSubadminToGroup(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->users()->addSubadminToGroup('alice', 'GroupA');

        $this->assertTrue($result);
    }

    public function testFailAddSubadminToGroup(): void
    {
        $this->expectException(NextCloudApiException::class);

        $this->fakeHttpResponse('fixtures/api/generic-bad-request.json', 400);

        Nextcloud::provisioning()->users()->addSubadminToGroup('alice', 'admin');
    }

    public function testRemoveSubadminFromGroup(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->users()->removeSubadminFromGroup('alice', 'GroupA');

        $this->assertTrue($result);
    }

    public function testFailRemoveSubadminFromGroup(): void
    {
        $this->expectException(NextCloudApiException::class);

        $this->fakeHttpResponse('fixtures/api/generic-bad-request.json', 400);

        Nextcloud::provisioning()->users()->removeSubadminFromGroup('alice', 'GroupA');
    }

    public function testGetUsers(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/users.json');

        $users = Nextcloud::provisioning()->users()->list();

        $this->assertCount(12, $users);
        $this->assertInstanceOf(UserId::class, $users->first());
    }

    public function testCreateUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/new-user-created.json');

        $request = new UserCreateRequest(
            userid: 'new user',
            password: 'password',
            displayName: 'New User',
            email: '@new@example.org',
            groups: ['GroupA'],
            subadmin: ['GroupA'],
            quota: 'test',
            language: 'en'
        );

        $user = Nextcloud::provisioning()->users()->create($request);

        $this->assertEquals('new user', $user->id());
    }

    public function testFailCreateUser(): void
    {
        $this->expectException(NextCloudApiException::class);
        $this->expectExceptionCode(102);
        $this->expectExceptionMessage('Gebruiker bestaat al');

        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/user-allready-exists.json', 400);

        $request = new UserCreateRequest(
            userid: 'admin',
            password: 'password',
            displayName: 'New User',
            email: 'new@example.org',
            groups: ['GroupA'],
            subadmin: ['GroupA'],
            quota: 'test',
            language: 'en'
        );

        Nextcloud::provisioning()->users()->create($request);
    }

    public function testGetUserDetails(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/users.json');

        $users = Nextcloud::provisioning()->users()->listDetails();

        $this->assertCount(12, $users);
        $this->assertInstanceOf(User::class, $users->first());
    }

    public function testGetDisabledUserDetails(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/disabled-users.json');

        $users = Nextcloud::provisioning()->users()->listDisabledDetails();

        $this->assertCount(2, $users);
        $this->assertInstanceOf(User::class, $users->first());
    }

    public function testSearchByPhone(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/users.json');

        // todo this does not work
        $users = Nextcloud::provisioning()->users()->searchByPhone('31', ['0612345678']);
    }

    public function testGetUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/user.json');

        $user = Nextcloud::provisioning()->users()->get('admin');

        $this->assertTrue($user->enabled());
        $this->assertEquals('admin', $user->id());
        $this->assertEquals('admin@example.net', $user->email());

        $this->assertEquals(-3, $user->quota()->free());
        $this->assertEquals(20575003, $user->quota()->used());
    }

    public function testGetCurrentUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/user.json');

        $user = Nextcloud::provisioning()->users()->get();

        $this->assertTrue($user->enabled());
        $this->assertEquals('admin', $user->id());
        $this->assertEquals('admin@example.net', $user->email());

        $this->assertEquals(-3, $user->quota()->free());
        $this->assertEquals(20575003, $user->quota()->used());
    }

    public function testGetUserEditableFields(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/editable-fields.json');

        $fields = Nextcloud::provisioning()->users()->fields('admin');

        $this->assertCount(14, $fields);
        $this->assertEquals('displayname', $fields->first()->name());
        $this->assertEquals('pronouns', $fields->last()->name());
    }

    public function testGetCurrentUserEditableFields(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/user-endpoint/editable-fields.json');

        $fields = Nextcloud::provisioning()->users()->fields();

        $this->assertCount(14, $fields);
        $this->assertEquals('displayname', $fields->first()->name());
        $this->assertEquals('pronouns', $fields->last()->name());
    }

    public function testGetCurrentUserApps(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/app-endpoint/apps.json');

        $apps = Nextcloud::provisioning()->users()->apps();

        $this->assertCount(26, $apps);
        $this->assertEquals('encryption', $apps->first()->id());
        $this->assertEquals('user_oidc', $apps->last()->id());
    }

    public function testUpdateUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->users()->update('admin', 'email', 'some@email.com');

        $this->assertTrue($result);
    }

    public function testDeleteUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->users()->delete('bob');

        $this->assertTrue($result);
    }

    public function testEnableUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->users()->enable('bob');

        $this->assertTrue($result);
    }

    public function testDisableUser(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->users()->disable('jane');

        $this->assertTrue($result);
    }
}
