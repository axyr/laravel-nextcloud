<?php

namespace Axyr\Nextcloud\ValueObjects;

class GroupId extends ValueObject
{
    public function id(): string
    {
        return (string)$this->getValue('id');
    }
}
