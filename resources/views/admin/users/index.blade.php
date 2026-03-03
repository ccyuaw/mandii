@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-6">
    
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Quản lý Người dùng</h1>
            <p class="text-sm text-slate-500 mt-1">Danh sách tất cả tài khoản trong hệ thống</p>
        </div>
        {{-- Có thể thêm ô tìm kiếm ở đây sau này --}}
    </div>

    {{-- Bảng danh sách --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Thông tin người dùng</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Vai trò</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ngày tham gia</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        
                        {{-- Cột 1: Avatar + Tên + Email --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover border border-slate-200 shadow-sm" 
                                         src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=random' }}" 
                                         alt="{{ $user->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-slate-900">{{ $user->name }}</div>
                                    <div class="text-sm text-slate-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Cột 2: Đổi Vai trò (Role) --}}
                        <td class="px-6 py-4">
                            @if(auth()->id() !== $user->id) {{-- Không cho tự sửa role của mình --}}
                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" 
                                            class="text-sm rounded-lg border-slate-200 py-1.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none cursor-pointer shadow-sm transition
                                            {{ $user->role === 'admin' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'bg-white text-slate-700' }}">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            @else
                                <span class="inline-block px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-sm font-bold border border-slate-200 cursor-not-allowed">
                                    Admin (Bạn)
                                </span>
                            @endif
                        </td>

                        {{-- Cột 3: Ngày tham gia --}}
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                        </td>

                        {{-- Cột 4: Hành động --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Nút Xem --}}
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="w-8 h-8 flex items-center justify-center text-blue-600 hover:bg-blue-50 rounded-lg transition" 
                                   title="Xem hồ sơ chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Nút Xóa (Ẩn nếu là chính mình) --}}
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                          onsubmit="return confirm('CẢNH BÁO:\nBạn có chắc chắn muốn xóa người dùng này?\nHành động này không thể hoàn tác.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 flex items-center justify-center text-red-500 hover:bg-red-50 rounded-lg transition" 
                                                title="Xóa tài khoản">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Phân trang --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection