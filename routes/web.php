<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\PhimController;
use App\Http\Controllers\SuatChieuController;
use App\Http\Controllers\VeController;
use App\Http\Controllers\TheLoaiController;
use App\Http\Controllers\PhimTheLoaiController;
use App\Http\Controllers\PhongChieuController;
use App\Http\Controllers\GheNgoiController;
use App\Http\Controllers\ChiTietVeController;
use App\Http\Controllers\DanhGiaPhimController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ThanhToanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Các route chính của ứng dụng (grouped under 'web' middleware).
|
*/

Route::middleware(['web'])->group(function () {

    // ===== TRANG CHỦ =====
    Route::get('/', [PhimController::class, 'index'])->name('phim.index');
    Route::get('/danh-sach-phim', [PhimController::class, 'list'])->name('phim.list');

    // ===== PHIM =====
    Route::get('/phim', [PhimController::class, 'index'])->name('phim.index');
    Route::get('/phim/{phim_id}', [PhimController::class, 'show'])->name('phim.show');

    // ===== NGƯỜI DÙNG =====
    Route::get('/nguoi_dung', [NguoiDungController::class, 'index']);
    Route::get('/nguoi_dung/{id}', [NguoiDungController::class, 'show']);

    // ===== SUẤT CHIẾU =====
    Route::get('/suat_chieu', [SuatChieuController::class, 'index']);
    Route::get('/suat_chieu/{id}', [SuatChieuController::class, 'show']);

    // ===== VÉ =====
    Route::get('/ve', [VeController::class, 'index']); // Danh sách vé
    Route::get('/ve/{id}', [VeController::class, 'show'])->name('ve.show'); // Chi tiết vé
    Route::get('/dat_ve/{suat_chieu_id}', [VeController::class, 'HienThiGheChoSC'])->name('pages.booking');
    Route::post('/luu_ve_tam_thoi', [VeController::class, 'LuuVeTamThoi'])->name('luu_ve_tam_thoi');
    Route::get('/chi_tiet_ve_tam_thoi/{ve_id}', [VeController::class, 'ChiTietVeTamThoi'])->name('chi_tiet_ve_tam_thoi');

    // Tạo vé (POST) — nếu cần bypass CSRF như trước
    Route::post('/tao_ve', [VeController::class, 'TaoVe_ChiTietVe'])
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->name('tao_ve');

    Route::get('/ketqua', [VeController::class, 'xuLySauThanhToan'])->name('momo.ketqua');

    // ===== THỂ LOẠI =====
    Route::get('/the_loai', [TheLoaiController::class, 'index']);
    Route::get('/the_loai/{id}', [TheLoaiController::class, 'show']);

    // ===== PHIM - THỂ LOẠI (LIÊN KẾT N-N) =====
    Route::get('/phim_the_loai', [PhimTheLoaiController::class, 'index']);
    Route::get('/phim_the_loai/{phim_id}/{the_loai_id}', [PhimTheLoaiController::class, 'show']);

    // ===== PHÒNG CHIẾU =====
    Route::get('/phong_chieu', [PhongChieuController::class, 'index']);
    Route::get('/phong_chieu/{id}', [PhongChieuController::class, 'show']);

    // ===== GHẾ NGỒI =====
    Route::get('/ghe_ngoi', [GheNgoiController::class, 'index']);
    Route::get('/ghe_ngoi/{id}', [GheNgoiController::class, 'show']);

    // ===== CHI TIẾT VÉ =====
    Route::get('/chi_tiet_ve', [ChiTietVeController::class, 'index']);
    Route::get('/chi_tiet_ve/{ve_id}/{ghe_id}', [ChiTietVeController::class, 'show']);

    // ===== ĐÁNH GIÁ PHIM =====
    Route::get('/danh_gia_phim', [DanhGiaPhimController::class, 'index']); // Danh sách đánh giá
    Route::get('/danh_gia_phim/{id}', [DanhGiaPhimController::class, 'show']); // Chi tiết đánh giá
    Route::post('/danh_gia_phim/{id}', [DanhGiaPhimController::class, 'TaoDanhGia'])->name('danhgiaphim.create');

    // ===== THANH TOÁN =====
    Route::post('/phuong_thuc_thanh_toan', [ThanhToanController::class, 'phuongThucThanhToan'])->name('phuong_thuc_thanh_toan');
    Route::get('/momo_payment', [ThanhToanController::class, 'momo_payment'])->name('momo_payment');

    // ===== ĐĂNG KÝ, ĐĂNG NHẬP =====
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form')->middleware('guest');
    Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt')->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ===== ROUTE BẢO VỆ =====
    Route::middleware(['auth'])->group(function () {
        // Hồ sơ người dùng (profile)
        Route::get('/profile', [NguoiDungController::class, 'showProfile'])->name('profile');
        Route::post('/profile', [NguoiDungController::class, 'updateProfile']);

        // Vé đã đặt
        Route::get('/profile/tickets', [NguoiDungController::class, 'showTickets'])->name('profile.tickets');

        // Đánh giá đã đánh giá
        Route::get('/profile/reviews', [NguoiDungController::class, 'showReviews'])->name('profile.reviews');
    });

    // ===== ADMIN ROUTES (YÊU CẦU ĐĂNG NHẬP + VAI TRÒ ADMIN) =====
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

        // Quản lý Phim
        Route::get('/phim', [\App\Http\Controllers\Admin\AdminPhimController::class, 'index'])->name('phim.index');
        Route::get('/phim/create', [\App\Http\Controllers\Admin\AdminPhimController::class, 'create'])->name('phim.create');
        Route::post('/phim', [\App\Http\Controllers\Admin\AdminPhimController::class, 'store'])->name('phim.store');
        Route::get('/phim/{phim_id}/edit', [\App\Http\Controllers\Admin\AdminPhimController::class, 'edit'])->name('phim.edit');
        Route::put('/phim/{phim_id}', [\App\Http\Controllers\Admin\AdminPhimController::class, 'update'])->name('phim.update');
        Route::delete('/phim/{phim_id}', [\App\Http\Controllers\Admin\AdminPhimController::class, 'destroy'])->name('phim.destroy');

        // Quản lý Thể loại
        Route::get('/theloai', [\App\Http\Controllers\Admin\AdminTheLoaiController::class, 'index'])->name('theloai.index');
        Route::get('/theloai/create', [\App\Http\Controllers\Admin\AdminTheLoaiController::class, 'create'])->name('theloai.create');
        Route::post('/theloai', [\App\Http\Controllers\Admin\AdminTheLoaiController::class, 'store'])->name('theloai.store');
        Route::get('/theloai/{id}/edit', [\App\Http\Controllers\Admin\AdminTheLoaiController::class, 'edit'])->name('theloai.edit');
        Route::put('/theloai/{id}', [\App\Http\Controllers\Admin\AdminTheLoaiController::class, 'update'])->name('theloai.update');
        Route::delete('/theloai/{id}', [\App\Http\Controllers\Admin\AdminTheLoaiController::class, 'destroy'])->name('theloai.destroy');

        // Quản lý Phòng chiếu
        Route::get('/phongchieu', [\App\Http\Controllers\Admin\AdminPhongChieuController::class, 'index'])->name('phongchieu.index');
        Route::get('/phongchieu/create', [\App\Http\Controllers\Admin\AdminPhongChieuController::class, 'create'])->name('phongchieu.create');
        Route::post('/phongchieu', [\App\Http\Controllers\Admin\AdminPhongChieuController::class, 'store'])->name('phongchieu.store');
        Route::get('/phongchieu/{phong_id}/edit', [\App\Http\Controllers\Admin\AdminPhongChieuController::class, 'edit'])->name('phongchieu.edit');
        Route::put('/phongchieu/{phong_id}', [\App\Http\Controllers\Admin\AdminPhongChieuController::class, 'update'])->name('phongchieu.update');
        Route::delete('/phongchieu/{phong_id}', [\App\Http\Controllers\Admin\AdminPhongChieuController::class, 'destroy'])->name('phongchieu.destroy');

        // Quản lý Ghế ngồi
        Route::get('/ghengoi', [\App\Http\Controllers\Admin\AdminGheNgoiController::class, 'index'])->name('ghengoi.index');
        Route::get('/ghengoi/create', [\App\Http\Controllers\Admin\AdminGheNgoiController::class, 'create'])->name('ghengoi.create');
        Route::post('/ghengoi', [\App\Http\Controllers\Admin\AdminGheNgoiController::class, 'store'])->name('ghengoi.store');
        Route::post('/ghengoi/auto-generate', [\App\Http\Controllers\Admin\AdminGheNgoiController::class, 'autoGenerate'])->name('ghengoi.autogenerate');
        Route::delete('/ghengoi/{ghe_id}', [\App\Http\Controllers\Admin\AdminGheNgoiController::class, 'destroy'])->name('ghengoi.destroy');

        // Quản lý Suất chiếu
        Route::get('/suatchieu', [\App\Http\Controllers\Admin\AdminSuatChieuController::class, 'index'])->name('suatchieu.index');
        Route::get('/suatchieu/create', [\App\Http\Controllers\Admin\AdminSuatChieuController::class, 'create'])->name('suatchieu.create');
        Route::post('/suatchieu', [\App\Http\Controllers\Admin\AdminSuatChieuController::class, 'store'])->name('suatchieu.store');
        Route::get('/suatchieu/{suat_chieu_id}/edit', [\App\Http\Controllers\Admin\AdminSuatChieuController::class, 'edit'])->name('suatchieu.edit');
        Route::put('/suatchieu/{suat_chieu_id}', [\App\Http\Controllers\Admin\AdminSuatChieuController::class, 'update'])->name('suatchieu.update');
        Route::delete('/suatchieu/{suat_chieu_id}', [\App\Http\Controllers\Admin\AdminSuatChieuController::class, 'destroy'])->name('suatchieu.destroy');
    });
});
