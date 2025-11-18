<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuatChieu;
use App\Models\Phim;
use App\Models\PhongChieu;
use Illuminate\Http\Request;

class AdminSuatChieuController extends Controller
{
    /**
     * Hiển thị danh sách suất chiếu
     */
    public function index(Request $request)
    {
        $query = SuatChieu::with(['phim', 'phongChieu']);

        // Tìm kiếm theo phim
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('phim', function ($q) use ($request) {
                $q->where('ten_phim', 'like', '%' . $request->search . '%');
            });
        }

        // Lọc theo phòng chiếu
        if ($request->has('phong_id') && $request->phong_id != '') {
            $query->where('phong_id', $request->phong_id);
        }

        // Lọc theo ngày chiếu
        if ($request->has('ngay_chieu') && $request->ngay_chieu != '') {
            $query->whereDate('ngay_chieu', $request->ngay_chieu);
        }

        $suatChieus = $query->orderBy('ngay_chieu', 'desc')
            ->orderBy('gio_bat_dau', 'desc')
            ->paginate(15)
            ->appends($request->all());

        $phongChieus = PhongChieu::all();

        return view('admin.suatchieu.index', compact('suatChieus', 'phongChieus'));
    }

    /**
     * Hiển thị form tạo suất chiếu mới
     */
    public function create()
    {
        $phims = Phim::where('trang_thai', '!=', 'ngung_chieu')->get();
        $phongChieus = PhongChieu::all();

        return view('admin.suatchieu.create', compact('phims', 'phongChieus'));
    }

    /**
     * Lưu suất chiếu mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phim_id' => 'required|exists:phim,phim_id',
            'phong_id' => 'required|exists:phong_chieu,phong_id',
            'ngay_chieu' => 'required|date',
            'gio_bat_dau' => 'required',
            'gio_ket_thuc' => 'required',
            'gia_ve' => 'required|numeric|min:0',
            'trang_thai' => 'required|in:sap_chieu,dang_chieu,da_ket_thuc',
        ], [
            'phim_id.required' => 'Vui lòng chọn phim',
            'phim_id.exists' => 'Phim không tồn tại',
            'phong_id.required' => 'Vui lòng chọn phòng chiếu',
            'phong_id.exists' => 'Phòng chiếu không tồn tại',
            'ngay_chieu.required' => 'Vui lòng chọn ngày chiếu',
            'ngay_chieu.date' => 'Ngày chiếu không hợp lệ',
            'gio_bat_dau.required' => 'Vui lòng nhập giờ bắt đầu',
            'gio_ket_thuc.required' => 'Vui lòng nhập giờ kết thúc',
            'gia_ve.required' => 'Vui lòng nhập giá vé',
            'gia_ve.numeric' => 'Giá vé phải là số',
            'gia_ve.min' => 'Giá vé không được âm',
        ]);

        // So sánh giờ bắt đầu và kết thúc (hỗ trợ chiếu qua nửa đêm)
        $start_time = $request->input('gio_bat_dau'); // Định dạng: "22:30"
        $end_time = $request->input('gio_ket_thuc');   // Định dạng: "00:30" (qua ngày)

        // Chuyển thành phút để so sánh
        list($start_h, $start_m) = explode(':', $start_time);
        list($end_h, $end_m) = explode(':', $end_time);

        $start_minutes = $start_h * 60 + $start_m;
        $end_minutes = $end_h * 60 + $end_m;

        // Nếu giờ kết thúc nhỏ hơn giờ bắt đầu, cộng 24 giờ (chiếu qua ngày)
        if ($end_minutes <= $start_minutes) {
            $end_minutes += 24 * 60;
        }

        // Nếu khoảng thời gian quá dài (> 24 giờ), báo lỗi
        if ($end_minutes - $start_minutes > 24 * 60) {
            return back()->withInput()->withErrors(['gio_ket_thuc' => 'Suất chiếu không được quá 24 giờ']);
        }

        // Tạo suat_chieu_id tự động
        $lastSuat = SuatChieu::orderBy('suat_chieu_id', 'desc')->first();
        if ($lastSuat) {
            $lastNumber = (int) substr($lastSuat->suat_chieu_id, 2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $suat_chieu_id = 'sc' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        SuatChieu::create([
            'suat_chieu_id' => $suat_chieu_id,
            'phim_id' => $validated['phim_id'],
            'phong_id' => $validated['phong_id'],
            'ngay_chieu' => $validated['ngay_chieu'],
            'gio_bat_dau' => $validated['gio_bat_dau'],
            'gio_ket_thuc' => $validated['gio_ket_thuc'],
            'gia_ve' => $validated['gia_ve'],
            'trang_thai' => $validated['trang_thai'],
        ]);

        return redirect()->route('admin.suatchieu.index')->with('success', 'Thêm suất chiếu thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa suất chiếu
     */
    public function edit($suat_chieu_id)
    {
        $suatChieu = SuatChieu::findOrFail($suat_chieu_id);
        $phims = Phim::all();
        $phongChieus = PhongChieu::all();

        return view('admin.suatchieu.edit', compact('suatChieu', 'phims', 'phongChieus'));
    }

    /**
     * Cập nhật suất chiếu
     */
    public function update(Request $request, $suat_chieu_id)
    {
        $validated = $request->validate([
            'phim_id' => 'required|exists:phim,phim_id',
            'phong_id' => 'required|exists:phong_chieu,phong_id',
            'ngay_chieu' => 'required|date',
            'gio_bat_dau' => 'required',
            'gio_ket_thuc' => 'required',
            'gia_ve' => 'required|numeric|min:0',
            'trang_thai' => 'required|in:sap_chieu,dang_chieu,da_ket_thuc',
        ]);

        $suatChieu = SuatChieu::findOrFail($suat_chieu_id);
        $suatChieu->update($validated);

        return redirect()->route('admin.suatchieu.index')->with('success', 'Cập nhật suất chiếu thành công!');
    }

    /**
     * Xóa suất chiếu
     */
    public function destroy($suat_chieu_id)
    {
        $suatChieu = SuatChieu::findOrFail($suat_chieu_id);
        $suatChieu->delete();

        return redirect()->route('admin.suatchieu.index')->with('success', 'Xóa suất chiếu thành công!');
    }
}
