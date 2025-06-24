<?php

namespace Axyr\Nextcloud\ValueObjects;

use Illuminate\Support\Collection;

class HoverCard extends ValueObject
{
    public function userId(): string
    {
        return (string)$this->getValue('userId');
    }

    public function displayName(): string
    {
        return (string)$this->getValue('displayName');
    }

    /**
     * @return Collection<HoverCardAction>
     */
    public function actions(): Collection
    {
        return collect((array)$this->getValue('actions'))->mapInto(HoverCardAction::class);
    }
}
