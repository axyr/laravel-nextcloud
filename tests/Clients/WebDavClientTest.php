<?php

namespace Axyr\Nextcloud\Tests\Clients;

use Axyr\Nextcloud\Clients\WebDavClient;
use Axyr\Nextcloud\Enums\WebDavNamespace;
use Axyr\Nextcloud\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class WebDavClientTest extends TestCase
{
    #[DataProvider('dataPathGeneration')]
    public function testPathGeneration(?WebDavNamespace $namespace = null, ?string $path = null, ?string $expectedFullUrl = null): void
    {
        $client = app(WebDavClient::class)->forNamespace($namespace);

        $this->assertEquals($expectedFullUrl, $client->getFullPath($path));
    }

    public static function dataPathGeneration(): array
    {
        return [
            [
                'namespace' => null,
                'path' => 'test',
                'expectedFullUrl' => 'http://nextcloud.local/remote.php/dav/test',
            ],
            [
                'namespace' => WebDavNamespace::Files,
                'path' => 'Media/Office/Screenshot%202025-06-20%20at%2013.49.08.png',
                'expectedFullUrl' => 'http://nextcloud.local/remote.php/dav/files/admin/Media/Office/Screenshot%202025-06-20%20at%2013.49.08.png',
            ],
            [
                'namespace' => WebDavNamespace::Files,
                'path' => '/remote.php/dav/files/admin/Media/Office/Screenshot%202025-06-20%20at%2013.49.08.png',
                'expectedFullUrl' => 'http://nextcloud.local/remote.php/dav/files/admin/Media/Office/Screenshot%202025-06-20%20at%2013.49.08.png',
            ],
            [
                'namespace' => WebDavNamespace::Calendars,
                'path' => 'Media/Office/Screenshot%202025-06-20%20at%2013.49.08.png',
                'expectedFullUrl' => 'http://nextcloud.local/remote.php/dav/calendars/admin/Media/Office/Screenshot%202025-06-20%20at%2013.49.08.png',
            ],
        ];
    }
}
