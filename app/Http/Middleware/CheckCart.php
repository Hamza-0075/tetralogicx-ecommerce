<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;

class CheckCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart = Session::get('cart',[]);
        if (empty($cart)) {
            return redirect()->route('cart.detail')->with('error','Your cart is empty.');
        }
        return $next($request);
    }
}
