<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    /**
     * Проверка является ли пользователь админом
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->user() || !$request->user()->isAdmin()) {
            return response()->json([
                'result' => false,
                'message' => 'У вас нет прав администратора'
            ]);
        }

        return $next($request);
    }
}
