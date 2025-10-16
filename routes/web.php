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


// ✅ NHÓM TOÀN BỘ ROUTE TRONG MIDDLEWARE 'web'
Route::middleware(['web'])->group(function () {

    // ===== TRANG CHỦ =====
    // Route::get('/', function () {
    //     return view('welcome');
    // })->name('home');
    Route::get('/', [PhimController::class, 'index'])->name('phim.index');
    // ===== NGƯỜI DÙNG =====
    Route::get('/nguoi_dung', [NguoiDungController::class, 'index']);
    Route::get('/nguoi_dung/{id}', [NguoiDungController::class, 'show']);

    // ===== PHIM =====
    Route::get('/phim', [PhimController::class, 'index'])->name('phim.index');
    Route::get('/phim/{id}', [PhimController::class, 'show']);

    // ===== SUẤT CHIẾU =====
    Route::get('/suat_chieu', [SuatChieuController::class, 'index']);
    Route::get('/suat_chieu/{id}', [SuatChieuController::class, 'show']);

    // ===== VÉ =====
    Route::get('/ve', [VeController::class, 'index']);
    Route::get('/ve/{id}', [VeController::class, 'show']);

    // ===== THỂ LOẠI =====
    Route::get('/the_loai', [TheLoaiController::class, 'index']);
    Route::get('/the_loai/{id}', [TheLoaiController::class, 'show']);

    // ===== PHIM - THỂ LOẠI =====
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
    Route::get('/danh_gia_phim', [DanhGiaPhimController::class, 'index']);
    Route::get('/danh_gia_phim/{id}', [DanhGiaPhimController::class, 'show']);

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
        Route::get('/profile', [NguoiDungController::class, 'showProfile'])->name('profile');
        Route::post('/profile', [NguoiDungController::class, 'updateProfile']);
    });
});
