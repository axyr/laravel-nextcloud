<?php

namespace Axyr\Nextcloud\ValueObjects;

use Illuminate\Support\Collection;

class ProfileFields extends ValueObject
{
    public function userId(): string
    {
        return (string)$this->getValue('userId');
    }

    public function displayName(): ?string
    {
        return $this->getValue('displayname');
    }

    public function timezone(): ?string
    {
        return $this->getValue('timezone');
    }

    public function timezoneOffset(): ?int
    {
        return $this->getValue('timezoneOffset');
    }

    public function isUserAvatarVisible(): bool
    {
        return (bool)$this->getValue('isUserAvatarVisible');
    }

    /**
     * @return Collection<ProfileFieldAction>
     */
    public function actions(): Collection
    {
        return collect((array)$this->getValue('actions'))->mapInto(ProfileFieldAction::class);
    }

    /**
     * Return all other dynamic fields not explicitly defined.
     */
    public function customAttributes(): array
    {
        return collect($this->getAttributes())
            ->except(['userId', 'displayname', 'timezone', 'timezoneOffset', 'isUserAvatarVisible', 'actions'])
            ->toArray();
    }
}
