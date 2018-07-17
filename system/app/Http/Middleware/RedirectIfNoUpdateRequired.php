<?php

namespace App\Http\Middleware;

use Closure;
use App\Service\Setup\UpdateService;

class RedirectIfNoUpdateRequired
{
    protected $updateService;

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;
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
        if (!$this->updateService->needsUpdate()) {
            abort(404);
        }

        return $next($request);
    }
}
