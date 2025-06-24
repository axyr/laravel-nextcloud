<?php

namespace Axyr\Nextcloud\Tests\Api\V2\Provisioning;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\Group;
use Axyr\Nextcloud\ValueObjects\GroupId;
use Axyr\Nextcloud\ValueObjects\User;
use Axyr\Nextcloud\ValueObjects\UserId;

class GroupEndpointTest extends TestCase
{
    public function testListGroups(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/group-endpoint/groups.json');

        $groups = Nextcloud::provisioning()->groups()->list();

        $this->assertCount(3, $groups);
        $this->assertInstanceOf(GroupId::class, $groups->first());
        $this->assertEquals('admin', $groups->last()->id());
    }

    public function testListGroupDetails(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/group-endpoint/group-details.json');

        $groups = Nextcloud::provisioning()->groups()->listDetails();

        $this->assertCount(3, $groups);
        $this->assertInstanceOf(Group::class, $groups->first());
        $this->assertEquals('admin', $groups->last()->id());
        $this->assertEquals('admin', $groups->last()->displayname());
        $this->assertEquals(1, $groups->last()->usercount());
        $this->assertEquals(0, $groups->last()->disabled());
        $this->assertTrue($groups->last()->canAdd());
        $this->assertTrue($groups->last()->canRemove());
    }

    public function testGetGroupSubadmins(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/group-endpoint/subadmins.json');

        $users = Nextcloud::provisioning()->groups()->subadmins('GroupA');

        $this->assertCount(1, $users);
        $this->assertInstanceOf(UserId::class, $users->first());
        $this->assertEquals('alice', $users->last()->id());
    }

    public function testCreateGroup(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->groups()->create([
            'groupid' => 'groupid',
            'displayname' => 'displayname',
        ]);

        $this->assertTrue($result);
    }

    public function testUpdateGroup(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->groups()->update('groupid', 'new displayname');

        $this->assertTrue($result);
    }

    public function testDeleteGroup(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::provisioning()->groups()->delete('groupid');

        $this->assertTrue($result);
    }

    public function testGetUsers(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/group-endpoint/users.json');

        $users = Nextcloud::provisioning()->groups()->users('admin');

        $this->assertCount(2, $users);
        $this->assertInstanceOf(UserId::class, $users->first());
        $this->assertEquals('john', $users->last()->id());
    }

    public function testGetUserDetails(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/group-endpoint/user-details.json');

        $users = Nextcloud::provisioning()->groups()->userDetails('admin');

        $this->assertCount(2, $users);
        $this->assertInstanceOf(User::class, $users->first());
        $this->assertEquals('admin', $users->first()->id());
        $this->assertEquals('john', $users->last()->id());
    }
}
