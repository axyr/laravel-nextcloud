<?php

namespace Axyr\Nextcloud;

use Illuminate\Support\ServiceProvider;

class NextcloudServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    protected function registerConfig(): void
    {
        $file = __DIR__ . '/../config/nextcloud.php';

        $this->mergeConfigFrom($file, 'nextcloud');
        $this->publishes([$file => config_path('nextcloud.php')]);
    }
}
