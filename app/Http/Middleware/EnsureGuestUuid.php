<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EnsureGuestUuid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Only assign a guest UUID if the user is not authenticated
            if (!Cookie::has('guest_uuid')) {
                $guestUuid = (string) Str::uuid();
                Cookie::queue('guest_uuid', $guestUuid, 60 * 24 * 365); // 1 year
            }
        }

        return $next($request);
    }
}
