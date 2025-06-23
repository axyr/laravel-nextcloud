<?php

namespace Axyr\Nextcloud\ValueObjects;

class Group extends ValueObject
{
    public function name(): string
    {
        return (string)$this->getValue('name');
    }
}
