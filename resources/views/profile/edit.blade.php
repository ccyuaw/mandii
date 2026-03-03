@extends('layouts.app')
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong>Có lỗi xảy ra:</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Thông báo --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
                <i class="fa-solid fa-check-circle mr-2"></i> <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- FORM CHÍNH: DÙNG GRID ĐỂ ÉP CHIA CỘT --}}
        {{-- grid-cols-1: Mobile 1 cột --}}
        {{-- md:grid-cols-12: Tablet/PC chia làm 12 cột nhỏ --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" 
              class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            @csrf
            @method('patch')

            {{-- CỘT TRÁI (AVATAR): Chiếm 4/12 phần (khoảng 30%) --}}
            <div class="md:col-span-4 lg:col-span-3 space-y-6">
                
                {{-- Card Ảnh đại diện --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 text-center relative">
                    <div class="relative inline-block group">
                        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=random&size=200' }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-slate-50 shadow-md mb-3 mx-auto"
                             id="avatar-preview"
                             alt="Avatar">
                        
                        <label for="avatar-upload" class="absolute bottom-2 right-0 bg-blue-600 text-white w-8 h-8 flex items-center justify-center rounded-full cursor-pointer hover:bg-blue-700 transition shadow-lg" title="Đổi ảnh">
                            <i class="fa-solid fa-camera text-xs"></i>
                        </label>
                        <input type="file" name="avatar" id="avatar-upload" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <h2 class="text-lg font-bold text-slate-800 mt-2">{{ $user->name }}</h2>
                    <p class="text-slate-500 text-xs">{{ $user->email }}</p>

                    {{-- Menu bên dưới avatar --}}
                    <div class="mt-6 text-left border-t border-slate-100 pt-4">
                        <a href="#" class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg font-bold text-sm mb-2">
                            <i class="fa-solid fa-user-pen w-5 text-center"></i> Hồ sơ cá nhân
                        </a>
                        <a href="{{ route('booking.history') }}" class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:bg-slate-50 rounded-lg transition text-sm">
                            <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i> Lịch sử khám
                        </a>
                        <button form="logout-form" type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition text-sm mt-2">
                            <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Đăng xuất
                        </button>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI (THÔNG TIN): Chiếm 8/12 phần (khoảng 70%) --}}
            <div class="md:col-span-8 lg:col-span-9">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 pb-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-regular fa-id-card text-blue-500"></i> Thông tin chi tiết
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        {{-- Họ tên --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm bg-slate-50 focus:bg-white">
                        </div>

                        {{-- Email --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Email (Không thể sửa)</label>
                            <input type="email" value="{{ $user->email }}" readonly
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed focus:outline-none text-sm">
                        </div>

                        {{-- SĐT --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Số điện thoại</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="09xxxxxxx"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                        </div>

                        {{-- Ngày sinh --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Ngày sinh</label>
                            <input type="date" name="birthday" value="{{ old('birthday', $user->birthday) }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                        </div>

                        {{-- Giới tính --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Giới tính</label>
                            <select name="gender" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                                <option value="">-- Chọn --</option>
                                <option value="nam" {{ old('gender', $user->gender) == 'nam' ? 'selected' : '' }}>Nam</option>
                                <option value="nu" {{ old('gender', $user->gender) == 'nu' ? 'selected' : '' }}>Nữ</option>
                                <option value="khac" {{ old('gender', $user->gender) == 'khac' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>

                        {{-- Địa chỉ --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Địa chỉ</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Số nhà, đường..."
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                        </div>
                    </div>

                    {{-- Tiền sử bệnh --}}
                    <div class="mb-8">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-2">
                            <i class="fa-solid fa-notes-medical text-red-500"></i> Tiền sử bệnh / Dị ứng thuốc
                        </label>
                        <textarea name="medical_history" rows="3" 
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition bg-yellow-50 text-sm"
                            placeholder="Ví dụ: Dị ứng Penicillin, Tiểu đường...">{{ old('medical_history', $user->medical_history) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2.5 px-6 rounded-lg hover:bg-blue-700 transition shadow-md shadow-blue-200 text-sm">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Lưu thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Form đăng xuất ẩn để nút bên trên gọi tới --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection