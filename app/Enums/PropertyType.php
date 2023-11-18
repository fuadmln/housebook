<?php

namespace App\Enums;

enum PropertyType: int
{
    case NEW = 0;
    case SECOND = 1;

    public static function getString($val): string
    {
        return match ($val) {
            self::NEW => 'new',
            self::SECOND => 'second',
        };
    }

    public static function toArray(): array
    {
        $cases = [];

        foreach (self::cases() as $case) {
            $cases[$case->name] = $case->value;
        }

        return $cases;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}