<?php

namespace Axyr\Nextcloud\ValueObjects;

class AutoCompleteStatus extends ValueObject
{
    public function status(): string
    {
        return (string)$this->getValue('status');
    }

    public function message(): string
    {
        return (string)$this->getValue('message');
    }

    public function icon(): string
    {
        return (string)$this->getValue('icon');
    }

    public function clearAt(): int
    {
        return (int)$this->getValue('clearAt');
    }
}
