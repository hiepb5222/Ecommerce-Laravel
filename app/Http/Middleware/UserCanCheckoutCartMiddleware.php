<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;

class UserCanCheckoutCartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $cart = app(Cart::class)->firstOrCreateBy(auth()->user()->id);
        if($cart->product->count() > 0) {
            return $next($request);
        }else{
            abort(404, 'Không có sản phẩm nào trong cửa hàng'); 
        }
        return $next($request);
    }
}
