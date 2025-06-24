<?php

namespace Axyr\Nextcloud\Tests\Api\V2\Core;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;

class AppPasswordEndpointTest extends TestCase
{
    public function testGetAppPassword(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/apppassword.json');

        $apppassword = Nextcloud::core()->appPassword()->get();

        $this->assertEquals('abcdefghijklmnop', $apppassword->appPassword());
    }

    public function testRotateAppPassword(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/apppassword.json');

        $apppassword = Nextcloud::core()->appPassword()->rotate();

        $this->assertEquals('abcdefghijklmnop', $apppassword->appPassword());
    }

    public function testConfirmAppPassword(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/apppassword.json');

        $apppassword = Nextcloud::core()->appPassword()->confirm();

        $this->assertEquals('abcdefghijklmnop', $apppassword->appPassword());
    }

    public function testDeleteAppPassword(): void
    {
        $this->fakeHttpResponse('fixtures/api/generic-ok.json');

        $result = Nextcloud::core()->appPassword()->delete();

        $this->assertTrue($result);
    }
}
