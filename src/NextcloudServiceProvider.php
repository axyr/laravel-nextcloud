<?php

namespace Axyr\Nextcloud;

use Axyr\Nextcloud\Config\Config;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class NextcloudServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    public function boot()
    {
        $this->setUpClient();
    }

    protected function registerConfig(): void
    {
        $file = __DIR__ . '/../config/nextcloud.php';

        $this->mergeConfigFrom($file, 'nextcloud');
        $this->publishes([$file => config_path('nextcloud.php')]);
    }

    protected function setUpClient(): void
    {
        $this->app->singleton('nextcloud.config', function (Container $app) {
            return new Config(
                baseUrl: $app['config']['nextcloud']['base_url'],
                username: $app['config']['nextcloud']['username'],
                password: $app['config']['nextcloud']['password'],
                defaultHeaders: $app['config']['nextcloud']['default_headers'],
            );
        });

        $this->app->singleton('nextcloud', function (Container $app) {
            $client = $app['config']['nextcloud']['client'];

            return new $client($app['nextcloud.config']);
        });
    }
}
