<?php

namespace Axyr\Nextcloud\ValueObjects;

class Status extends ValueObject
{
    public function installed(): bool
    {
        return (bool)$this->getValue('installed');
    }

    public function maintenance(): bool
    {
        return (bool)$this->getValue('maintenance');
    }

    public function needsDbUpgrade(): bool
    {
        return (bool)$this->getValue('needsDbUpgrade');
    }

    public function version(): string
    {
        return (string)$this->getValue('version');
    }

    public function versionstring(): string
    {
        return (string)$this->getValue('versionstring');
    }

    public function edition(): string
    {
        return (string)$this->getValue('edition');
    }

    public function productname(): string
    {
        return (string)$this->getValue('productname');
    }

    public function extendedSupport(): bool
    {
        return (bool)$this->getValue('extendedSupport');
    }
}
