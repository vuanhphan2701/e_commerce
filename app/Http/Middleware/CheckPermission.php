<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = Auth::user(); // Lấy user đang đăng nhập

        if (!$user) {
            // Nếu chưa đăng nhập
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        // Nếu user không có role phù hợp
        if (!$user->hasPermission($permission)) {
            return response()->json(['error' => 'Forbidden - You do not have permission'], 403);
        }

        return $next($request);
    }
}
