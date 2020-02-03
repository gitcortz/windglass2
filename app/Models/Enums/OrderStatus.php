<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class StockStatus extends BasicEnum
{
    const Void = 0;
    const Open = 10;
    const Processing = 20;
    const Delivering = 30;
    const Completed = 40;
    
}
