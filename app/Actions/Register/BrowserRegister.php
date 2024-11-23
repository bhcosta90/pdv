<?php

declare(strict_types = 1);

namespace App\Actions\Register;

use App\Models\Register;
use App\Trait\StoreActionTrait;
use Illuminate\Support\Facades\Cookie;

class BrowserRegister
{
    use StoreActionTrait;

    public function handle(): ?Register
    {
        $registerCookie = Cookie::get('register');

        if (!$registerCookie) {
            return null;
        }

        /** @var Register $register */
        $register = $this->store->registers()->whereCode($registerCookie)->first();

        return $register;
    }
}
