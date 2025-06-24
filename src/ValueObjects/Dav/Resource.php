<?php

namespace Axyr\Nextcloud\ValueObjects\Dav;

use Axyr\Nextcloud\ValueObjects\ValueObject;

class Resource extends ValueObject
{
    public function path(): string
    {
        return (string)$this->getValue('href');
    }

    public function isCollection(): bool
    {
        return (bool)$this->getValue('is_collection');
    }

    public function lastModified(): ?string
    {
        return $this->getValue('last_modified');
    }

    public function etag(): ?string
    {
        return $this->getValue('etag');
    }
}
