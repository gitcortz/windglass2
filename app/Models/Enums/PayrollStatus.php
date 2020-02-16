<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class PayrollStatus extends BasicEnum
{
    const Void = 0;
    const Draft = 1;
    const Processed = 2;
    
}
