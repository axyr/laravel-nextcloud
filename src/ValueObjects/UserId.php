<?php

namespace Axyr\Nextcloud\ValueObjects;

class UserId extends ValueObject
{
    public function id(): string
    {
        return (string)$this->getValue('id');
    }
}
