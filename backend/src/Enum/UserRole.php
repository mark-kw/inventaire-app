<?php

namespace App\Enum;


enum UserRole: string
{
    case ADMIN = 'ADMIN';
    case MANAGER = 'MANAGER';
    case STAFF = 'STAFF';
}
