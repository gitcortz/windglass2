<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class TransferStatus extends BasicEnum
{
    const IsVoid = 0;
    const IsDraft = 1;
    const Transfer = 10;
    const Received = 20;
    
}
