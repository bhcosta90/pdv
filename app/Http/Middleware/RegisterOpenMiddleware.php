<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Actions\Register\BrowserRegister;
use Closure;
use Illuminate\Http\Request;

class RegisterOpenMiddleware
{
    public function __construct(protected BrowserRegister $browserRegister)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $register = $this->browserRegister->handle();

        if (blank($register->opened_by)) {
            return redirect()->route('register.define', ['action' => 'open']);
        }

        return $next($request);
    }
}
