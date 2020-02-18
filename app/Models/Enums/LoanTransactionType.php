<?php

namespace App\Models\Enums;

use App\Models\Enums\BasicEnum;

class LoanTransactionType extends BasicEnum
{
    const NewLoan = 1;
    const ModifyLoan = 2;
    const Payroll = 3;
    
}
