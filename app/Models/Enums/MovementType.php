<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class MovementType extends BasicEnum
{
    const Received = 10;
    const Transfer = 20;
    const Sold = 30;
    const Adjustment = 40;
    const Lost = 50;
    const Destroyed = 60;
    
}
