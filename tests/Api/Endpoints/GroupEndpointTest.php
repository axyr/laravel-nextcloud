<?php

namespace Axyr\Nextcloud\Tests\Api\Endpoints;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\Group;

class GroupEndpointTest extends TestCase
{
    public function testGetGroups(): void
    {
        $this->fakeHttpResponse('fixtures/api/endpoints/group-endpoint/groups.json');

        $groups = Nextcloud::api()->groups()->get();

        $this->assertCount(3, $groups);
        $this->assertInstanceOf(Group::class, $groups->first());
        $this->assertEquals('admin', $groups->last()->name());
    }
}
