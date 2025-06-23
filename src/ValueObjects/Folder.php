<?php

namespace Axyr\Nextcloud\ValueObjects;

use Illuminate\Support\Collection;

class Folder extends ValueObject
{
    public function id(): int
    {
        return (int)$this->getValue('id');
    }

    public function basename(): string
    {
        return (string)$this->getValue('basename');
    }

    public function children(): Collection
    {
        return collect($this->getValue('children'))->mapInto(__CLASS__);
    }
}
