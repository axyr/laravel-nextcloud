<?php

namespace Axyr\Nextcloud\ValueObjects;

class UserStatus extends ValueObject
{
    public function userId(): ?string
    {
        return $this->getValue('userId');
    }

    public function status(): ?string
    {
        return $this->getValue('status');
    }

    public function statusIcon(): ?string
    {
        return $this->getValue('statusIcon');
    }

    public function message(): ?string
    {
        return $this->getValue('message');
    }

    public function messageId(): ?string
    {
        return $this->getValue('messageId');
    }

    public function clearAt(): ?int
    {
        return $this->getValue('clearAt');
    }

    public function lastActivity(): ?int
    {
        return $this->getValue('lastActivity');
    }

    public function online(): ?bool
    {
        return $this->getValue('online');
    }

    public function icon(): ?string
    {
        return $this->getValue('icon');
    }

    public function messageIsPredefined(): ?bool
    {
        return $this->getValue('messageIsPredefined');
    }
}
