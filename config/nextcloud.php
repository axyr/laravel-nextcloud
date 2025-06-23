<?php

return [
    'client' => Axyr\Nextcloud\Api\Client::class,
    'username' => env('NEXTCLOUD_USERNAME'),
    'password' => env('NEXTCLOUD_PASSWORD'),
    'base_url' => env('NEXTCLOUD_BASE_URL', 'http://nextcloud.local/ocs/v2.php'),
    'default_headers' => [
        'OCS-APIRequest' => 'true',
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ],
];
