<?php

namespace Axyr\Nextcloud\ValueObjects;

class AppId extends ValueObject
{
    public function id(): string
    {
        return (string)$this->getValue('id');
    }
}
