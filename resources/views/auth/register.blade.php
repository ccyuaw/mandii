@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl">
        <div class="text-center">
            <i class="fa-solid fa-user-plus text-5xl text-blue-600"></i>
            <h2 class="mt-6 text-3xl font-extrabold text-slate-900">Tạo tài khoản mới</h2>
            <p class="mt-2 text-sm text-slate-600">
                Đã có tài khoản?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Đăng nhập ngay
                </a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-3 rounded-lg text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Họ và tên</label>
                    <input id="name" name="name" type="text" required 
                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        placeholder="Nguyễn Văn A">
                </div>
                <div>
                    <label for="email-address" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required 
                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        placeholder="vidu@gmail.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Mật khẩu</label>
                    <input id="password" name="password" type="password" required 
                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        placeholder="••••••••">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Nhập lại mật khẩu</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        placeholder="••••••••">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-200 transition">
                    ĐĂNG KÝ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection