<?php

namespace Axyr\Nextcloud\ValueObjects;

class Capability extends ValueObject
{
    public function capability(): string
    {
        return (string)$this->getValue('capability');
    }

    public function attributes(): array
    {
        return (array)$this->getAttributes();
    }
}
