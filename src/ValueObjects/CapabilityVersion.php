<?php

namespace Axyr\Nextcloud\ValueObjects;

class CapabilityVersion extends ValueObject
{
    public function major(): int
    {
        return (int)$this->getValue('major');
    }

    public function minor(): int
    {
        return (int)$this->getValue('minor');
    }

    public function micro(): int
    {
        return (int)$this->getValue('micro');
    }

    public function string(): string
    {
        return (string)$this->getValue('string');
    }

    public function edition(): string
    {
        return (string)$this->getValue('edition');
    }

    public function extendedSupport(): bool
    {
        return (bool)$this->getValue('extendedSupport');
    }
}
