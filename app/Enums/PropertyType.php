<?php

namespace App\Enums;

enum PropertyType: int
{
    // use Enums;

    case NEW = 0;
    case SECOND = 1;

    public static function getString($val): string
    {
        return match ($val) {
            self::NEW => 'New',
            self::SECOND => 'Second',
        };
    }
}