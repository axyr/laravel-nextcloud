<?php

namespace Axyr\Nextcloud\Tests\Api\Provisioning;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\Group;
use Axyr\Nextcloud\ValueObjects\User;

class GroupEndpointTest extends TestCase
{
    public function testGetGroups(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/group-endpoint/groups.json');

        $groups = Nextcloud::provisioning()->groups()->list();

        $this->assertCount(3, $groups);
        $this->assertInstanceOf(Group::class, $groups->first());
        $this->assertEquals('admin', $groups->last()->name());
    }

    public function testGetGroupSubadmins(): void
    {
        $this->fakeHttpResponse('fixtures/api/provisioning/group-endpoint/subadmins.json');

        $users = Nextcloud::provisioning()->groups()->subadmins('GroupA');

        $this->assertCount(1, $users);
        $this->assertInstanceOf(User::class, $users->first());
        $this->assertEquals('alice', $users->last()->id());
    }
}
