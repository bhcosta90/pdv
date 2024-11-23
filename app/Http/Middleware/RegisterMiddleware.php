<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegisterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!\Cookie::has('register')) {
            return redirect()->route('register.define');
        }

        return $next($request);
    }
}
