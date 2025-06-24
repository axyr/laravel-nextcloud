<?php

namespace Axyr\Nextcloud\ValueObjects;

class ProfileFieldAction extends ValueObject
{
    public function id(): string
    {
        return (string)$this->getValue('id');
    }

    public function icon(): string
    {
        return (string)$this->getValue('icon');
    }

    public function title(): string
    {
        return (string)$this->getValue('title');
    }

    public function target(): string
    {
        return (string)$this->getValue('target');
    }
}
