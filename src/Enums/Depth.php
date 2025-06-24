<?php

namespace Axyr\Nextcloud\Enums;

enum Depth: string
{
    case Zero = '0';
    case One = '1';
    case Infinity = 'infinity';

    public function description(): string
    {
        return match ($this) {
            self::Zero => 'Only the resource itself',
            self::One => 'The resource and its immediate children',
            self::Infinity => 'The resource and all its descendants recursively',
        };
    }
}
