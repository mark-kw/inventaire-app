<?php

namespace App\Enum;


enum MaintenanceStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
}
