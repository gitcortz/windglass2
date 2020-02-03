<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class PaymentStatus extends BasicEnum
{
    const NotPaid = 10;
    const Paid = 20;
    
}
