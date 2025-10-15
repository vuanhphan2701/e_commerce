<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user(); // Lấy user đang đăng nhập


        if (!$user) {
            // Nếu chưa đăng nhập
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Nếu user không có vai trò hợp lệ
        if (!$user->roles()->whereIn('name', $roles)->exists()) {
            return response()->json(['error' => 'Forbidden - Role not allowed'], 403);
        }

        return $next($request);
    }
}
