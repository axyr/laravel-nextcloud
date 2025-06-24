<?php

namespace Axyr\Nextcloud\ValueObjects;

use Illuminate\Support\Collection;

class Capabilities extends ValueObject
{
    public function version(): CapabilityVersion
    {
        return new CapabilityVersion($this->getValue('version'));
    }

    /**
     * @return Collection<Capability>
     */
    public function list(): Collection
    {
        return collect((array)$this->getValue('capabilities'))
            ->map(function (array $attributes, string $capability) {
                return new Capability(array_merge(['capability' => $capability], $attributes));
            });
    }
}
