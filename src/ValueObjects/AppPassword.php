<?php

namespace Axyr\Nextcloud\ValueObjects;

class AppPassword extends ValueObject
{
    public function appPassword(): string
    {
        return (string)$this->getValue('apppassword');
    }
}
