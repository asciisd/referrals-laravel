<?php


namespace Asciisd\ReferaralsLaravel\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Referrals
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $referral_token = $request->query('ref');
        if ($referral_token) {
            return $next($request)->withCookie(\cookie('referral_token', $referral_token, intval(config('referral_token_cookie_lifetime'))));
        }
 
        return $next($request);
    }
}