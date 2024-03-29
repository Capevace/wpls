<?php

namespace App\Http\Middleware;

use Closure;
use App\Service\Setup\InstallService;

class RedirectIfInstalled
{
    protected $installService;

    public function __construct(InstallService $installService)
    {
        $this->installService = $installService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->installService->installedAlready()) {
            abort(404);
        }

        return $next($request);
    }
}
