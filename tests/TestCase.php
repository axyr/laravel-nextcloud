<?php

namespace Axyr\Nextcloud\Tests;

use Axyr\Nextcloud\NextcloudServiceProvider;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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

    protected function fakeHttpResponse(string $fixture, int $statusCode = 200, ?string $endPoint = null): Factory
    {
        $endPoint = $endPoint ?: config('nextcloud.base_url') . '*';
        $isJson = Str::endsWith($fixture, '.json');

        return Http::fake([
            $endPoint => Http::response(
                $this->fixtureFileContent($fixture),
                $statusCode,
                ['Content-Type' => $isJson ? 'application/json' : 'application/xml']
            ),
        ]);
    }

    protected function fixtureFileContent(string $fixture): string
    {
        return file_get_contents($this->baseTestingPath($fixture));
    }

    protected function baseTestingPath(string $file = ''): string
    {
        return str_replace('/vendor/orchestra/testbench-core/laravel', '/tests', base_path()) . '/' . $file;
    }
}
