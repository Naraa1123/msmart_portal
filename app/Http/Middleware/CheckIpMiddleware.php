<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $allowedIPs = [
            '66.181.185.100',
            '103.212.119.162',
            '66.181.190.90',
            '66.181.177.114',
            '66.181.187.139'
        ];

        $currentIP = $request->ip();
        dd($currentIP);
        $initialIP = session('user_initial_ip', $currentIP);

        if ($currentIP !== $initialIP) {
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect('/login')->with('message', 'Your IP address has changed. Please login again.');
        }
        else
        {
            if (!in_array($currentIP, $allowedIPs)) {
                auth()->logout();
                session()->invalidate();
                session()->regenerateToken();
                abort(403, 'Та Академийн интернэтэд холбогдсон үедээ хандалт хийнэ үү');
            }
            return $next($request);
        }
    }
}
