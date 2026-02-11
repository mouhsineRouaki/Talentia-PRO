<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $cacheKey = "user-online-{$userId}";
            // modification  last_seen
            Cache::put($cacheKey, true, now()->addMinutes(5));
            // modification apres 2min
            $lastUpdate = Cache::get("user-last-update-{$userId}");
            if (!$lastUpdate || $lastUpdate < now()->subMinutes(2)) {
                Auth::user()->update(['last_seen' => now()]);
                Cache::put("user-last-update-{$userId}", now(), now()->addMinutes(5));
            }
        }
        
        return $next($request);
    }
}