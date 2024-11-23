<?php

declare(strict_types = 1);

namespace App\Models\Enums;

enum RegisterHistoryAction: int
{
    case Open  = 1;
    case Close = 2;
}
