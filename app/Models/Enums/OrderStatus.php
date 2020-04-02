<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class OrderStatus extends BasicEnum
{
    const Void = 0;
    const Draft = 10;
    const Ordered = 20;
    const Delivered = 30;
    const Completed = 40;
    
}
