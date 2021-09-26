<?php

namespace BlueSea\Cms\Middlewares;

use Closure;
use Illuminate\Http\Request;
use BlueSea\Cms\Facades\PageCache;

class PageCacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        PageCache::create($request, $response);

        return $next($request);
    }
}
