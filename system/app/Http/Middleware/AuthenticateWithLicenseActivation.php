<?php

namespace App\Http\Middleware;

use App\LicenseActivation;
use Closure;

class AuthenticateWithLicenseActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $activationId = $request->input('activation');

        // $activation = LicenseActivation::find($activationId);
        // $request->attributes->add(['some' => 'body']);
        // var_dump($request->attributes);

        return $next($request);
    }
}
