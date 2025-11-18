<?php

namespace App\Http\Controllers;

use App\Models\Phim;
use App\Models\TheLoai;
use App\Models\SuatChieu;
use App\Models\Ve;
use Illuminate\Http\Request;

class PhimController extends Controller
{
    // Trang chủ: chỉ hiển thị 8 phim mới nhất + 8 phim sắp chiếu
    public function index()
    {
        // Phim đang chiếu (trang_thai = 'dang_chieu')
        $phimsChieuGan = Phim::where('trang_thai', 'dang_chieu')
            ->with(['theLoais', 'danhGia'])
            ->orderBy('ngay_cong_chieu', 'desc')
            ->limit(8)
            ->get();

        // Phim sắp chiếu (trang_thai = 'sap_chieu')
        $phimsSapChieu = Phim::where('trang_thai', 'sap_chieu')
            ->with(['theLoais', 'danhGia'])
            ->orderBy('ngay_cong_chieu', 'desc')
            ->limit(8)
            ->get();

        $theLoais = TheLoai::all();
        return view('phim.index', compact('phimsChieuGan', 'phimsSapChieu', 'theLoais'));
    }

    // Trang danh sách phim: với search và filter
    public function list(Request $request)
    {
        $theLoais = TheLoai::all();

        // Base query cho filter
        $baseQuery = function ($query) use ($request) {
            // Tìm kiếm theo tên phim
            if ($request->has('search') && $request->search != '') {
                $query->where('ten_phim', 'like', '%' . $request->search . '%');
            }

            // Lọc theo thể loại - fix ambiguous column
            if ($request->has('the_loai') && $request->the_loai != '') {
                $query->whereHas('theLoais', function ($q) use ($request) {
                    $q->where('the_loai.the_loai_id', $request->the_loai);
                });
            }
        };

        // Phim đang chiếu (trang_thai = 'dang_chieu')
        $phimsChieuGan = Phim::where('trang_thai', 'dang_chieu')
            ->with(['theLoais', 'danhGia'])
            ->tap($baseQuery)
            ->orderBy('ngay_cong_chieu', 'desc')
            ->paginate(12, ['*'], 'page_chieu');

        // Phim sắp chiếu (trang_thai = 'sap_chieu')
        $phimsSapChieu = Phim::where('trang_thai', 'sap_chieu')
            ->with(['theLoais', 'danhGia'])
            ->tap($baseQuery)
            ->orderBy('ngay_cong_chieu', 'desc')
            ->paginate(12, ['*'], 'page_sap');

        return view('phim.list', compact('phimsChieuGan', 'phimsSapChieu', 'theLoais'));
    }

    public function show($phim_id)
    {
        $phim = Phim::with(['danhGia.nguoiDung', 'theLoais'])->find($phim_id);

        if (!$phim) {
            abort(404, 'Phim không tìm thấy');
        }

        // Chỉ lấy suất chiếu trong tương lai (ngày chiếu >= hôm nay)
        $phim->suatChieu = SuatChieu::where('phim_id', $phim_id)
            ->whereDate('ngay_chieu', '>=', now()->toDateString())
            ->with('phongChieu')
            ->orderBy('ngay_chieu')
            ->orderBy('gio_bat_dau')
            ->get();

        return view('pages.detail', compact('phim'));
    }
}
