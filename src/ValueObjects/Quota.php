<?php

namespace Axyr\Nextcloud\ValueObjects;

class Quota extends ValueObject
{
    public function free(): int
    {
        return (int)$this->getValue('free');
    }

    public function used(): int
    {
        return (int)$this->getValue('used');
    }

    public function total(): int
    {
        return (int)$this->getValue('total');
    }

    public function relative(): int
    {
        return (int)$this->getValue('relative');
    }

    public function quota(): int
    {
        return (int)$this->getValue('quota');
    }
}
