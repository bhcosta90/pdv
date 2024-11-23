<?php

declare(strict_types = 1);

namespace App\Interfaces;

use App\Models\{Store, User};

interface UserInterface
{
    public function store(): ?Store;

    public function user(): ?User;
}
