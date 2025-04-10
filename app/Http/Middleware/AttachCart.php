<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttachCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api')->check()) {
            $user = auth('api')->user();

            $cart = $user->cart()->firstOrCreate([]);

            $guestToken = null;
        } else {
            $guestToken = $request->cookie('guest_token') ?? generate_guest_token();

            $cart = Cart::firstOrCreate([
                'guest_token' => $guestToken,
            ]);
        }

        $request->attributes->set('cart', $cart);
        $request->attributes->set('guest_token', $guestToken);

        $response = $next($request);

        if ($guestToken) {
            $response->cookie('guest_token', $guestToken, 60 * 24 * 30);
        }

        return $response;
    }
}
