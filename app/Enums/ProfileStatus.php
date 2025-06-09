<?php

namespace App\Enums;

enum ProfileStatus: string
{
    // Make enum for profile statuses: inactive, pending, active
    case Inactive = 'inactive';
    case Pending = 'pending';
    case Active = 'active';

    /** @return array<string> */
    public static function toArray(): array
    {
        return [
            self::Inactive->value,
            self::Pending->value,
            self::Active->value,
        ];
    }
}
