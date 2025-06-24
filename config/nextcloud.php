<?php

return [
    'client' => Axyr\Nextcloud\Api\ApiClient::class,
    'username' => env('NEXTCLOUD_USERNAME'),
    'password' => env('NEXTCLOUD_PASSWORD'),
    'base_url' => env('NEXTCLOUD_BASE_URL', 'http://nextcloud.local/'),
    'web_dav_entry_point' => env('NEXTCLOUD_WEB_DAV_ENTRY_POINT', 'remote.php/dav/'),
];
