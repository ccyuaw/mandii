<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login'); // Đảm bảo bạn có file resources/views/auth/login.blade.php
    }

    // Xử lý đăng nhập
    public function login(Request $request)
{
    // 1. Validate dữ liệu
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // 2. Thử đăng nhập
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // --- ĐOẠN CODE QUAN TRỌNG CẦN THÊM ---
        
        // Kiểm tra: Nếu là Admin thì chuyển sang trang Admin
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // -------------------------------------

        // Nếu là User bình thường thì về trang Dashboard cũ
        return redirect()->route('dashboard');
    }

    // 3. Nếu sai mật khẩu
    return back()->withErrors([
        'email' => 'Email hoặc mật khẩu không chính xác.',
    ]);
}

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
{
    // 1. Validate dữ liệu
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // 2. Tạo User
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
    ]);

    // 3. Gửi email xác nhận (QUAN TRỌNG)
    //event(new \Illuminate\Auth\Events\Registered($user));

    // 4. Đăng nhập luôn
    auth()->login($user);

    // 5. Đẩy sang Dashboard 
    // (Tại đây Middleware sẽ tự chặn lại và hiện trang Verify cho bạn)
    return redirect()->route('dashboard'); 
}

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}