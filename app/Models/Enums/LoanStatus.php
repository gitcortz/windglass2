<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class LoanStatus extends BasicEnum
{
    const IsVoid = 0;
    const ForApproval = 10;
    const Loaned = 20;
    const Paid = 30;
    
}
