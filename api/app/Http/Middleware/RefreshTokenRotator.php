<?php

namespace App\Http\Middleware;

use App\Actions\Token\IssueToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenRotator
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->routeIs('auth.refresh') && Auth::check()) {
            $user = Auth::user();
            $tokenData = IssueToken::execute($user);

            $data = $response->getData(true);
            $data['access_token'] = $tokenData->access_token;
            $data['expires_in'] = $tokenData->expires_in;
            $response->setData($data);

            $refreshCookie = Cookie::make(
                'refresh_token',
                $tokenData->refresh_token,
                now()->addDays(7),
                '/',
                null,
                false,
                true,
                false,
                'Strict'
            );

            $response->headers->setCookie($refreshCookie);
        }

        return $response;
    }
}
