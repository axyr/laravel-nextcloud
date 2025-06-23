<?php

namespace Axyr\Nextcloud\ValueObjects;

class InvalidRequest extends ValueObject
{
    public function status(): string
    {
        return (string)$this->getValue('status');
    }

    public function statuscode(): int
    {
        return (int)$this->getValue('statuscode');
    }

    public function message(): string
    {
        return (string)$this->getValue('message');
    }
}
