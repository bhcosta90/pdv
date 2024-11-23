<?php

declare(strict_types = 1);

namespace App\Models\Enums;

enum RegisterHistoryType: int
{
    case Credit  = 1;
    case Debit   = 2;
    case Success = 3;
}
