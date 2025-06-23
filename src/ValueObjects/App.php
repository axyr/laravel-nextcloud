<?php

namespace Axyr\Nextcloud\ValueObjects;

use Illuminate\Support\Collection;

class App extends ValueObject
{
    public function id(): string
    {
        return (string)$this->getValue('id');
    }

    public function name(): string
    {
        return (string)$this->getValue('name');
    }

    public function summary(): string
    {
        return (string)$this->getValue('summary');
    }

    public function description(): string
    {
        return (string)$this->getValue('description');
    }

    public function version(): string
    {
        return (string)$this->getValue('version');
    }

    public function licence(): string
    {
        return (string)$this->getValue('licence');
    }

    public function authors(): Collection
    {
        return collect($this->getValue('author') ?? []);
    }

    public function namespace(): string
    {
        return (string)$this->getValue('namespace');
    }

    public function types(): Collection
    {
        return collect($this->getValue('types') ?? []);
    }

    public function categories(): Collection
    {
        return collect($this->getValue('category') ?? []);
    }

    public function bugs(): string
    {
        return (string)$this->getValue('bugs');
    }

    public function minNextcloudVersion(): ?string
    {
        return $this->getValue('dependencies.nextcloud.@attributes.min-version');
    }

    public function maxNextcloudVersion(): ?string
    {
        return $this->getValue('dependencies.nextcloud.@attributes.max-version');
    }

    public function backgroundJobs(): Collection
    {
        return collect($this->getValue('background-jobs') ?? []);
    }

    public function repairSteps(string $phase): Collection
    {
        return collect($this->getValue("repair-steps.{$phase}") ?? []);
    }

    public function commands(): Collection
    {
        return collect($this->getValue('commands') ?? []);
    }

    public function personalSettings(): Collection
    {
        return collect($this->getValue('settings.personal') ?? []);
    }

    public function adminSettings(): Collection
    {
        return collect($this->getValue('settings.admin') ?? []);
    }

    public function adminSections(): Collection
    {
        return collect($this->getValue('settings.admin-section') ?? []);
    }

    public function personalSections(): Collection
    {
        return collect($this->getValue('settings.personal-section') ?? []);
    }

    public function activitySettings(): Collection
    {
        return collect($this->getValue('activity.settings') ?? []);
    }

    public function activityFilter(): ?string
    {
        return $this->getValue('activity.filters.filter');
    }

    public function activityProviders(): Collection
    {
        return collect($this->getValue('activity.providers') ?? []);
    }

    public function collaborationPlugins(): Collection
    {
        $plugin = $this->getValue('collaboration.plugins.plugin');

        return collect(is_array($plugin) ? $plugin : [$plugin])->map(function ($plugin) {
            return is_array($plugin) ? $plugin['@value'] ?? null : $plugin;
        })->filter();
    }

    public function publicFiles(): ?string
    {
        return $this->getValue('public.files');
    }
}
