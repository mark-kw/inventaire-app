<?php

namespace App\Enum;


enum RoomStatus: string
{
    case AVAILABLE = 'available';
    case OCCUPIED = 'occupied';
    case HOUSEKEEPING = 'housekeeping';
    case MAINTENANCE = 'maintenance';
    case OUT_OF_SERVICE = 'out_of_service';
}
