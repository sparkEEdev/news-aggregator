<?php

namespace App\Traits;

trait EnumHelpers
{

    /**
     * @return array<int, int|string>
     */
    public static function valuesToArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
