<?php

namespace Axyr\Nextcloud\ValueObjects;

class HoverCardAction extends ValueObject
{
    public function title(): string
    {
        return (string)$this->getValue('title');
    }

    public function icon(): string
    {
        return (string)$this->getValue('icon');
    }

    public function hyperlink(): string
    {
        return (string)$this->getValue('hyperlink');
    }

    public function appId(): string
    {
        return (string)$this->getValue('appId');
    }
}
