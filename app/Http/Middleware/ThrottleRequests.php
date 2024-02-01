<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;

class ThrottleRequests extends ThrottleRequestsWithRedis
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        if (app()->environment('production')) {
            return parent::handle(...func_get_args());
        }

        return $next($request);
    }
}
