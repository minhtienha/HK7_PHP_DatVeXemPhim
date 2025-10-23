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
    Route::get('/phuong_thuc_thanh_toan', [ThanhToanController::class, 'phuongThucThanhToan'])->name('phuong_thuc_thanh_toan');
    Route::get('/momo_payment', [ThanhToanController::class, 'momo_payment'])->name('momo_payment');

    // ===== ĐĂNG KÝ, ĐĂNG NHẬP =====
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form')->middleware('guest');
    Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt')->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ===== ROUTE BẢO VỆ =====
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return 'Trang admin';
        });
        Route::get('/user/profile', function () {
            return 'Trang cá nhân';
        });

        // Hồ sơ người dùng (profile)
        Route::get('/profile', [NguoiDungController::class, 'showProfile'])->name('profile');
        Route::post('/profile', [NguoiDungController::class, 'updateProfile']);
    });
});
