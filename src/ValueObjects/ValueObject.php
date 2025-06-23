<?php

namespace Axyr\Nextcloud\ValueObjects;

use Illuminate\Support\Arr;

abstract class ValueObject
{
    public function __construct(private readonly array $attributes = []) {}

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getValue(string $key): mixed
    {
        return Arr::get($this->attributes, $key);
    }
}
