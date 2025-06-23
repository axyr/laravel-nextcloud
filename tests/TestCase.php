<?php

namespace Axyr\Nextcloud\Tests;

use Axyr\Nextcloud\NextcloudServiceProvider;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected function getPackageProviders($app)
    {
        return [
            NextcloudServiceProvider::class,
        ];
    }

    protected function fakeHttpResponse(string $fixture, int $statusCode = 200, ?string $endPoint = null): void
    {
        $fixture = file_get_contents($this->baseTestingPath($fixture));

        $endPoint = $endPoint ?: config('nextcloud.base_url') . '*';

        Http::fake([
            $endPoint => Http::response(
                $fixture,
                $statusCode,
                ['Content-Type' => 'application/json']
            ),
        ]);
    }

    protected function baseTestingPath(string $file = ''): string
    {
        return str_replace('/vendor/orchestra/testbench-core/laravel', '/tests', base_path()) . '/' . $file;
    }
}
