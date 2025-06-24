<?php

namespace Axyr\Nextcloud;

use Axyr\Nextcloud\Config\Config;
use Axyr\Nextcloud\Contracts\ConfigInterface;
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
        $this->app->singleton(ConfigInterface::class, function (Container $app) {
            return new Config(
                baseUrl: $app['config']['nextcloud']['base_url'],
                webDavEntryPoint: $app['config']['nextcloud']['web_dav_entry_point'],
                username: $app['config']['nextcloud']['username'],
                password: $app['config']['nextcloud']['password']
            );
        });

        $this->app->singleton('nextcloud', function (Container $app) {
            return app($app['config']['nextcloud']['client']);
        });
    }
}
