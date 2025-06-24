<?php

namespace Axyr\Nextcloud\ValueObjects;

class Capability extends ValueObject
{
    public function capability(): string
    {
        return (string)$this->getValue('capability'); // core, bruteforce, etc, the keys of the array
    }

    public function attributes(): array
    {
        return (array)$this->getAttributes();
    }
}
