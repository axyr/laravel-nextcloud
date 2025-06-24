<?php

namespace Axyr\Nextcloud\ValueObjects;

class AutoCompleteResult extends ValueObject
{
    public function id(): string
    {
        return (string)$this->getValue('id');
    }

    public function label(): string
    {
        return (string)$this->getValue('label');
    }

    public function icon(): string
    {
        return (string)$this->getValue('icon');
    }

    public function source(): string
    {
        return (string)$this->getValue('source');
    }

    public function subline(): string
    {
        return (string)$this->getValue('subline');
    }

    public function shareWithDisplayNameUnique(): string
    {
        return (string)$this->getValue('shareWithDisplayNameUnique');
    }

    public function status(): ?AutoCompleteStatus
    {
        $statusData = $this->getValue('status');

        return is_array($statusData) ? new AutoCompleteStatus($statusData) : null;
    }
}
