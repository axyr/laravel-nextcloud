<?php

namespace Axyr\Nextcloud\ValueObjects;

class User extends ValueObject
{
    public function enabled(): bool
    {
        return (bool)$this->getValue('enabled');
    }

    public function storageLocation(): string
    {
        return (string)$this->getValue('storageLocation');
    }

    public function id(): string
    {
        return (string)$this->getValue('id');
    }

    public function firstLoginTimestamp(): int
    {
        return (int)$this->getValue('firstLoginTimestamp');
    }

    public function lastLoginTimestamp(): int
    {
        return (int)$this->getValue('lastLoginTimestamp');
    }

    public function lastLogin(): int
    {
        return (int)$this->getValue('lastLogin');
    }

    public function backend(): string
    {
        return (string)$this->getValue('backend');
    }

    public function subadmin(): array
    {
        return (array)$this->getValue('subadmin');
    }

    public function quota(): Quota
    {
        return new Quota($this->getValue('quota'));
    }

    public function manager(): string
    {
        return (string)$this->getValue('manager');
    }

    public function email(): ?string
    {
        return $this->getValue('email');
    }

    public function additionalMail(): array
    {
        return (array)$this->getValue('additional_mail');
    }

    public function displayName(): string
    {
        return (string)$this->getValue('displayname') ?: (string)$this->getValue('display-name');
    }

    public function phone(): string
    {
        return (string)$this->getValue('phone');
    }

    public function address(): string
    {
        return (string)$this->getValue('address');
    }

    public function website(): string
    {
        return (string)$this->getValue('website');
    }

    public function twitter(): string
    {
        return (string)$this->getValue('twitter');
    }

    public function fediverse(): string
    {
        return (string)$this->getValue('fediverse');
    }

    public function organisation(): string
    {
        return (string)$this->getValue('organisation');
    }

    public function role(): string
    {
        return (string)$this->getValue('role');
    }

    public function headline(): string
    {
        return (string)$this->getValue('headline');
    }

    public function biography(): string
    {
        return (string)$this->getValue('biography');
    }

    public function profileEnabled(): bool
    {
        return (bool)intval($this->getValue('profile_enabled'));
    }

    public function pronouns(): string
    {
        return (string)$this->getValue('pronouns');
    }

    public function groups(): array
    {
        return (array)$this->getValue('groups');
    }

    public function language(): string
    {
        return (string)$this->getValue('language');
    }

    public function locale(): string
    {
        return (string)$this->getValue('locale');
    }

    public function notifyEmail(): ?string
    {
        return $this->getValue('notify_email');
    }

    public function backendCapabilities(): array
    {
        return (array)$this->getValue('backendCapabilities');
    }
}
