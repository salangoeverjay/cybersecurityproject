<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Redirect HTTP requests to HTTPS and attach HSTS on secure responses.
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $forceHttps = (bool) config('security.force_https', false);

        if ($forceHttps && !$request->isSecure()) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        $response = $next($request);

        if ($forceHttps && $request->isSecure()) {
            $hsts = 'max-age='.max(0, (int) config('security.hsts_max_age', 31536000));

            if ((bool) config('security.hsts_include_subdomains', true)) {
                $hsts .= '; includeSubDomains';
            }

            if ((bool) config('security.hsts_preload', false)) {
                $hsts .= '; preload';
            }

            $response->headers->set('Strict-Transport-Security', $hsts);
        }

        return $response;
    }
}

