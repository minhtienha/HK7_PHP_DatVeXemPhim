<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Phim;
use App\Models\SuatChieu;
use App\Models\Ve;
use App\Models\NguoiDung;
use App\Models\PhongChieu;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard admin
     */
    public function index()
    {
        // Thống kê số lượng
        $tongPhim = Phim::count();
        $tongPhongChieu = PhongChieu::count();
        $tongSuatChieu = SuatChieu::count();
        $tongNguoiDung = NguoiDung::where('vai_tro', 'user')->count();
        $tongVe = Ve::count();
        
        // Doanh thu (nếu có)
        $tongDoanhThu = Ve::sum('tong_tien');
        
        // Phim đang chiếu
        $phimDangChieu = Phim::where('trang_thai', 'dang_chieu')->count();
        
        // Suất chiếu hôm nay
        $suatChieuHomNay = SuatChieu::whereDate('ngay_chieu', today())->count();
        
        return view('admin.dashboard', compact(
            'tongPhim',
            'tongPhongChieu',
            'tongSuatChieu',
            'tongNguoiDung',
            'tongVe',
            'tongDoanhThu',
            'phimDangChieu',
            'suatChieuHomNay'
        ));
    }
}
