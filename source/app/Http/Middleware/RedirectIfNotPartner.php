<?php

namespace App\Http\Middleware;

use Closure;
use View;

class RedirectIfNotPartner
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
        if (!$request->session()->exists('bamaPartner')) {
            return redirect()->route('partnerLogin');
        }

        return $next($request);
    }
}
