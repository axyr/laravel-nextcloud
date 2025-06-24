<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\AutoCompleteResult;
use Illuminate\Support\Collection;

class AutoCompleteEndpoint extends AbstractEndpoint
{
    public function get(string $search, ?string $itemType = null, ?string $itemId = null, ?array $shareTypes = null, int $limit = 10): Collection
    {
        $query = [
            'search' => $search,
            'itemType' => $itemType,
            'itemId' => $itemId,
            'limit' => $limit,
        ];

        if ($shareTypes !== null) {
            foreach ($shareTypes as $index => $type) {
                $query["shareTypes[$index]"] = $type;
            }
        }

        $response = $this->http->get('/ocs/v2.php/core/autocomplete/get', $query);

        $this->throwExceptionIfNotOk($response);

        return collect($response->json('ocs.data'))->map(fn(array $entry) => new AutoCompleteResult($entry));
    }
}
