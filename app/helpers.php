<?php

declare(strict_types = 1);

use App\Facades\UserServiceFacade;
use App\Models\{Store, User};

function store(): ?Store
{
    return UserServiceFacade::store();
}

function user(): ?User
{
    return UserServiceFacade::user();
}
