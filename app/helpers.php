<?php

declare(strict_types = 1);

use App\Facades\UserFacade;
use App\Models\{Store, User};

function store(): ?Store
{
    return UserFacade::store();
}

function user(): ?User
{
    return UserFacade::user();
}
