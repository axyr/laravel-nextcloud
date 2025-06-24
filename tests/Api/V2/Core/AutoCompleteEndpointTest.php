<?php

namespace Axyr\Nextcloud\Tests\Api\V2\Core;

use Axyr\Nextcloud\Facades\Nextcloud;
use Axyr\Nextcloud\Tests\TestCase;
use Axyr\Nextcloud\ValueObjects\AutoCompleteResult;
use Axyr\Nextcloud\ValueObjects\AutoCompleteStatus;

class AutoCompleteEndpointTest extends TestCase
{
    public function testAutoCompleteReturnsCollectionOfResultsWithStatus(): void
    {
        $this->fakeHttpResponse('fixtures/api/core/autocomplete.json');

        $results = Nextcloud::core()->autoComplete()->get('user', null, null, null, 5);

        $this->assertEquals(5, $results->count());

        /** @var AutoCompleteResult $first */
        $first = $results->first();

        $this->assertInstanceOf(AutoCompleteResult::class, $first);
        $this->assertEquals('user1', $first->id());
        $this->assertEquals('user1', $first->label());
        $this->assertEquals('icon-user', $first->icon());
        $this->assertEquals('users', $first->source());
        $this->assertEquals('', $first->subline());
        $this->assertEquals('user1', $first->shareWithDisplayNameUnique());

        $status = $first->status();
        $this->assertInstanceOf(AutoCompleteStatus::class, $status);
        $this->assertEquals('string', $status->status());
        $this->assertEquals('string', $status->message());
        $this->assertEquals('string', $status->icon());
        $this->assertEquals(0, $status->clearAt());

        /** @var AutoCompleteResult $last */
        $last = $results->last();
        $this->assertNull($last->status());
    }
}
