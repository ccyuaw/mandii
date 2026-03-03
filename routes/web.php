<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- 1. AUTH & USER CONTROLLERS ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorPageController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;

// --- 2. ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

/*
|--------------------------------------------------------------------------
| KHU VỰC 0: CẤU HÌNH AUTH
|--------------------------------------------------------------------------
*/
Auth::routes([
    'verify'   => false,  // Bật xác minh email
    'login'    => false, // Tắt login mặc định (để dùng custom)
    'register' => false, // Tắt register mặc định
    'logout'   => false,
    'reset'    => true,  // Bật quên mật khẩu
]);

/*
|--------------------------------------------------------------------------
| KHU VỰC 1: PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Thông tin chung
Route::get('/pharmacy', [PharmacyController::class, 'index'])->name('pharmacy.index');
Route::get('/doctors', [DoctorPageController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{id}', [DoctorPageController::class, 'show'])->name('doctors.show');
Route::get('/news', [PostController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [PostController::class, 'show'])->name('news.show');
Route::get('/product/{id}', [PharmacyController::class, 'show'])->name('pharmacy.show');
// Cập nhật vị trí
Route::post('/update-location', function (Illuminate\Http\Request $request) {
    session(['user_location' => $request->location]);
    return response()->json(['status' => 'success']);
})->name('update.location');

// Callback MoMo
Route::get('/momo/callback', [PaymentController::class, 'momoCallback'])->name('momo.callback');

/*
|--------------------------------------------------------------------------
| KHU VỰC 2: GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| KHU VỰC 3: AUTH (ĐÃ ĐĂNG NHẬP)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // 🔥 ROUTE KIỂM TRA TRẠNG THÁI VERIFY (Cho JS gọi)
    // Phải nằm ngoài nhóm 'verified' để người chưa xác thực gọi được
    Route::get('/check-verify-status', function () {
        // Lấy dữ liệu tươi từ DB, không dùng auth()->user() để tránh cache session cũ
        $user = \App\Models\User::find(auth()->id());
        
        return response()->json([
            'verified' => $user && !is_null($user->email_verified_at)
        ]);
    })->name('check.verify.status');

    // --- Trang cơ bản (Không cần xác minh cũng vào được) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // --- NHÓM BẮT BUỘC XÁC MINH EMAIL ---
    Route::middleware(['auth'])->group(function () {
        
        // A. Booking
        Route::prefix('booking')->name('booking.')->group(function() {
            Route::get('/create/{doctor_id}', [BookingController::class, 'create'])->name('create');
            Route::post('/store', [BookingController::class, 'store'])->name('store');
            Route::get('/history', [BookingController::class, 'history'])->name('history');
            Route::put('/cancel/{id}', [BookingController::class, 'cancel'])->name('cancel');
            Route::get('/{id}/payment', [BookingController::class, 'showPayment'])->name('payment');
            Route::post('/{id}/payment', [BookingController::class, 'processPayment'])->name('payment.process');
        });
        Route::post('/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');

        // B. Chat
        Route::get('/appointment/{id}/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/appointment/{id}/messages', [ChatController::class, 'fetchMessages']);
        Route::post('/appointment/{id}/messages', [ChatController::class, 'sendMessage']);
        Route::get('/ai-chat', [ChatBotController::class, 'index'])->name('ai.index');
        Route::post('/ai-chat/send', [ChatBotController::class, 'sendMessage'])->name('ai.send');

        // C. Cart & Checkout
        Route::get('cart', [CartController::class, 'index'])->name('cart.index');
        Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::patch('update-cart', [CartController::class, 'update'])->name('cart.update');
        Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.process');

        // D. Orders
        Route::controller(UserOrderController::class)->prefix('my-orders')->name('my_orders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
            Route::put('/cancel/{id}', 'cancel')->name('cancel');
        });

       Route::match(['get', 'post'], '/payment/retry/{type}/{id}', [PaymentController::class, 'retryPayment'])->name('payment.retry');
    });
});

/*
|--------------------------------------------------------------------------
| KHU VỰC 4: ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::resource('users', AdminUserController::class);
        Route::resource('doctors', AdminDoctorController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('posts', AdminPostController::class);
        Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'destroy']);
        Route::controller(AdminOrderController::class)->prefix('orders')->name('orders.')->group(function () {
            Route::get('/', 'index')->name('index'); 
            Route::get('/{id}', 'show')->name('show'); 
            Route::put('/{id}/status', 'updateStatus')->name('update_status');
        });

        Route::get('/appointments', [AdminAppController::class, 'index'])->name('appointments.index');
        Route::patch('/appointments/{id}', [AdminAppController::class, 'updateStatus'])->name('appointments.update');
        Route::get('/appointment/{id}/chat', [ChatController::class, 'adminChat'])->name('chat.show');
        Route::patch('/users/{id}/update-role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
    });