<?php

namespace Axyr\Nextcloud\ValueObjects;

class Field extends ValueObject
{
    public function name(): string
    {
        return (string)$this->getValue('name');
    }
}
