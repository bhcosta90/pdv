<?php

declare(strict_types = 1);

namespace App\Actions\Register;

use App\Models\Register;
use App\Trait\StoreActionTrait;
use Illuminate\Support\Facades\Cookie;
use Lorisleiva\Actions\Concerns\AsAction;

class BrowserRegister
{
    use AsAction;
    use StoreActionTrait;

    public function handle(): ?Register
    {
        $registerCookie = Cookie::get('register') ?: Cookie::queue('register');

        if (!$registerCookie) {
            return null;
        }

        return $this->store->registers()->whereCode($registerCookie)->first();
    }
}
