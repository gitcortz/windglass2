<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class StockStatus extends BasicEnum
{
    const Void = 0;
    const Draft = 1;
    const Processed = 2;
    
}
