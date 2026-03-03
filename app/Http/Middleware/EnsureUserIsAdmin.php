<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Nếu đã đăng nhập VÀ có role là admin -> Cho qua
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Nếu không -> Báo lỗi 403 (Cấm truy cập) hoặc chuyển về trang chủ
        abort(403, 'Bạn không có quyền truy cập trang quản trị!');
        // return redirect('/'); // Hoặc dùng dòng này nếu muốn đẩy về trang chủ
    }
}