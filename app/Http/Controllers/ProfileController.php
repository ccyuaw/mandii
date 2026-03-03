<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
class ProfileController extends Controller
{
    // Hiển thị form sửa hồ sơ
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    // Cập nhật thông tin
    public function update(Request $request) // Sửa lại: Dùng Request thường thay vì ProfileUpdateRequest để dễ tùy biến
{
    
    $user = $request->user();

    // 1. Validate dữ liệu mở rộng
    $request->validate([
        'name' => 'required|string|max:255',
        
        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:255',
        'birthday' => 'nullable|date',
        'gender' => 'nullable|in:nam,nu,khac',
        'medical_history' => 'nullable|string',
        'avatar' => 'nullable|image|max:2048', // Thêm validate ảnh
    ]);

    // 2. Lấy dữ liệu từ form (trừ ảnh)
    $data = $request->except(['avatar']);


    // 3. Xử lý logic Upload Ảnh (Phần này Breeze chưa có)
    if ($request->hasFile('avatar')) {
        // Xóa ảnh cũ nếu có
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        // Lưu ảnh mới
        $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    // 4. Cập nhật Email (Logic gốc của Breeze - giữ lại)
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }
    

    // 5. Lưu tất cả vào DB
    $user->fill($data);
    
    $user->save();

    return Redirect::route('profile.edit')->with('success', 'Hồ sơ đã được cập nhật!');
}
}