<?php

namespace App\Http\Controllers;

use App\Models\DanhGiaPhim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhGiaPhimController extends Controller
{
    public function index()
    {
        $danhGias = DanhGiaPhim::all();
        return view('danh_gia_phim.index', compact('danhGias'));
    }

    public function show($id)
    {
        $danhGia = DanhGiaPhim::find($id);
        return view('danh_gia_phim.show', compact('danhGia'));
    }

    public function TaoDanhGia(Request $request)
    {
        $request->validate([
            'phim_id' => 'required|exists:phim,phim_id',
            'diem' => 'required|integer|min:1|max:5',
            'binh_luan' => 'nullable|string|max:500',
        ]);

        $danhGiaId = 'dg' . str_pad(DanhGiaPhim::count() + 1, 3, '0', STR_PAD_LEFT);

        DanhGiaPhim::create([
            'danh_gia_id' => $danhGiaId,
            'nguoi_dung_id' => 'nd002',
            'phim_id' => $request->phim_id,
            'diem' => $request->diem,
            'binh_luan' => $request->binh_luan,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đánh giá phim đã được tạo thành công!'
            ]);
        }

        return redirect()->back()->with('success', 'Đánh giá phim đã được tạo thành công!');
    }

    public function xoaDanhGia($id)
    {
        $danhGia = DanhGiaPhim::find($id);

        if (!$danhGia) {
            return redirect()->back()->with('error', 'Không tìm thấy đánh giá!');
        }
        // Kiểm tra xem người dùng hiện tại có phải là người tạo đánh giá không
        if ($danhGia->nguoi_dung_id !== Auth::user()->nguoi_dung_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa đánh giá này!');
        }

        $danhGia->delete();

        return redirect()->back()->with('success', 'Đã xóa đánh giá thành công!');
    }
}
