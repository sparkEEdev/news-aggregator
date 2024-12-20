<?php

namespace App\Enums;

use App\Traits\EnumHelpers;

enum Roles: string
{
    use EnumHelpers;

    case ADMIN = 'admin';
    case USER = 'user';
}
