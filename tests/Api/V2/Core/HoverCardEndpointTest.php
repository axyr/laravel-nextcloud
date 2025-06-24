<?php

namespace Axyr\Nextcloud\Tests\Api\V2\Core;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class HoverCardEndpointTest extends TestCase
{
    public function testGetHoverCard(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/hovercard.json');

        $hoverCard = Nextcloud::core()->hoverCard()->get('user1');

        $this->assertEquals('user1', $hoverCard->userId());
        $this->assertEquals('user1', $hoverCard->displayName());

        $actions = $hoverCard->actions();
        $this->assertCount(2, $actions);

        $this->assertEquals('Bekijk profiel', $actions[0]->title());
        $this->assertEquals('http://nextcloud.local/core/img/actions/profile.svg', $actions[0]->icon());
        $this->assertEquals('http://nextcloud.local/index.php/u/user1', $actions[0]->hyperlink());
        $this->assertEquals('profile', $actions[0]->appId());

        $this->assertEquals('07:50 • 2h behind', $actions[1]->title());
        $this->assertEquals('http://nextcloud.local/core/img/actions/recent.svg', $actions[1]->icon());
        $this->assertEquals('#', $actions[1]->hyperlink());
        $this->assertEquals('timezone', $actions[1]->appId());
    }
}
