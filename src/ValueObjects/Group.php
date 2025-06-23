<?php

namespace Axyr\Nextcloud\ValueObjects;

class Group extends ValueObject
{
    public function id(): string
    {
        return (string)$this->getValue('id');
    }

    public function displayname(): string
    {
        return (string)$this->getValue('displayname');
    }

    public function usercount(): int
    {
        return (int)$this->getValue('usercount');
    }

    public function disabled(): int
    {
        return (int)$this->getValue('disabled');
    }

    public function canAdd(): bool
    {
        return (bool)$this->getValue('canAdd');
    }

    public function canRemove(): bool
    {
        return (bool)$this->getValue('canRemove');
    }
}
