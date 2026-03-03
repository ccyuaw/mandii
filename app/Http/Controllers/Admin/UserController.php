<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Lấy danh sách user, trừ những người là admin cấp cao nếu cần
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Hàm đổi quyền nhanh (User <-> Admin)
    /**
     * Cập nhật vai trò người dùng (Admin <-> User)
     */
    public function updateRole(\Illuminate\Http\Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Chặn không cho tự hạ quyền của chính mình (để tránh mất quyền admin)
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Bạn không thể tự thay đổi quyền của chính mình!');
        }

        // Cập nhật role mới
        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Cập nhật phân quyền thành công!');
    }

    // Hàm xóa người dùng
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Đã xóa người dùng thành công!');
    }

    public function show($id)
{
    // Tìm người dùng theo ID
    $user = User::findOrFail($id);

    // Trả về view chi tiết
    return view('admin.users.show', compact('user'));
}
}