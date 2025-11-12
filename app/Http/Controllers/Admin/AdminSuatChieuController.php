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
    public function index()
    {
        $suatChieus = SuatChieu::with(['phim', 'phongChieu'])
            ->orderBy('ngay_chieu', 'desc')
            ->orderBy('gio_bat_dau', 'desc')
            ->paginate(15);
        
        return view('admin.suatchieu.index', compact('suatChieus'));
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
            'trang_thai' => 'required|in:con_cho,het_cho,huy',
        ]);

        // Tạo suat_chieu_id tự động
        $lastSuat = SuatChieu::orderBy('suat_chieu_id', 'desc')->first();
        if ($lastSuat) {
            $lastNumber = (int) substr($lastSuat->suat_chieu_id, 2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $suat_chieu_id = 'SC' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

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
            'trang_thai' => 'required|in:con_cho,het_cho,huy',
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
