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
use App\Http\Controllers\ThanhToanController;

// ===== TRANG CHỦ =====
Route::get('/', function () {
    return view('welcome');
});

// ===== NGƯỜI DÙNG =====
Route::get('/nguoi_dung', [NguoiDungController::class, 'index']); // Danh sách người dùng
Route::get('/nguoi_dung/{id}', [NguoiDungController::class, 'show']); // Xem chi tiết người dùng

// ===== PHIM =====
Route::get('/phim', [PhimController::class, 'index'])->name('phim.index'); // Danh sách phim
Route::get('/phim/{phim_id}', [PhimController::class, 'show'])->name('phim.show'); // Xem chi tiết phim

// ===== SUẤT CHIẾU =====
Route::get('/suat_chieu', [SuatChieuController::class, 'index']); // Danh sách suất chiếu
Route::get('/suat_chieu/{id}', [SuatChieuController::class, 'show']); // Chi tiết suất chiếu

// ===== VÉ =====
Route::get('/ve', [VeController::class, 'index']); // Danh sách vé
Route::get('/ve/{id}', [VeController::class, 'show'])->name('ve.show'); // Chi tiết vé
Route::get('/dat_ve/{suat_chieu_id}', [VeController::class, 'HienThiGheChoSC'])->name('pages.booking');
Route::post('/luu_ve_tam_thoi', [VeController::class, 'LuuVeTamThoi'])->name('luu_ve_tam_thoi');
Route::get('/chi_tiet_ve_tam_thoi/{ve_id}', [VeController::class, 'ChiTietVeTamThoi'])->name('chi_tiet_ve_tam_thoi');
Route::post('/tao_ve', [VeController::class, 'TaoVe_ChiTietVe'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('tao_ve');
Route::get('/ketqua', [VeController::class, 'xuLySauThanhToan'])->name('momo.ketqua');



// ===== THỂ LOẠI =====
Route::get('/the_loai', [TheLoaiController::class, 'index']); // Danh sách thể loại
Route::get('/the_loai/{id}', [TheLoaiController::class, 'show']); // Chi tiết thể loại

// ===== PHIM - THỂ LOẠI (LIÊN KẾT N-N) =====
Route::get('/phim_the_loai', [PhimTheLoaiController::class, 'index']); // Danh sách liên kết
Route::get('/phim_the_loai/{phim_id}/{the_loai_id}', [PhimTheLoaiController::class, 'show']); // Chi tiết liên kết

// ===== PHÒNG CHIẾU =====
Route::get('/phong_chieu', [PhongChieuController::class, 'index']); // Danh sách phòng chiếu
Route::get('/phong_chieu/{id}', [PhongChieuController::class, 'show']); // Chi tiết phòng chiếu

// ===== GHẾ NGỒI =====
Route::get('/ghe_ngoi', [GheNgoiController::class, 'index']); // Danh sách ghế
Route::get('/ghe_ngoi/{id}', [GheNgoiController::class, 'show']); // Chi tiết ghế

// ===== CHI TIẾT VÉ =====
Route::get('/chi_tiet_ve', [ChiTietVeController::class, 'index']); // Danh sách chi tiết vé
Route::get('/chi_tiet_ve/{ve_id}/{ghe_id}', [ChiTietVeController::class, 'show']); // Chi tiết ghế trong vé

// ===== ĐÁNH GIÁ PHIM =====
Route::get('/danh_gia_phim', [DanhGiaPhimController::class, 'index']); // Danh sách đánh giá
Route::get('/danh_gia_phim/{id}', [DanhGiaPhimController::class, 'show']); // Chi tiết đánh giá
Route::post('/danh_gia_phim/{id}', [DanhGiaPhimController::class, 'TaoDanhGia'])->name('danhgiaphim.create'); // Tạo đánh giá


// ===== THANH TOÁN =====
Route::get('/phuong_thuc_thanh_toan', [ThanhToanController::class, 'phuongThucThanhToan'])->name('phuong_thuc_thanh_toan'); // Trang chọn phương thức thanh toán
Route::get('/momo_payment', [ThanhToanController::class, 'momo_payment'])->name('momo_payment'); // Trang thanh toán Momo
