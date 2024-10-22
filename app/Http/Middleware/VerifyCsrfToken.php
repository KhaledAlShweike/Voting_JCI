<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class VerifyCsrfToken
{
    protected $except = [
        'api/*',
        '/*',
    ];

    public function handle(Request $request, Closure $next)
    {
        if ($this->isReading($request) || $this->runningUnitTests() || $this->inExceptArray($request)) {
            return $next($request);
        }

        // Verify CSRF token
        if ($this->isReading($request) || $this->isSameDomain($request)) {
            return $next($request);
        }

        throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('CSRF token mismatch.');
    }

    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }

    protected function isReading($request)
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }

    protected function runningUnitTests()
    {
        return app()->runningUnitTests();
    }

    protected function isSameDomain($request)
    {
        return $request->getHost() === config('app.url');
    }
}
