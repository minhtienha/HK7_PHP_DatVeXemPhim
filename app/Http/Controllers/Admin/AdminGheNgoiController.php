<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GheNgoi;
use App\Models\PhongChieu;
use Illuminate\Http\Request;

class AdminGheNgoiController extends Controller
{
    /**
     * Hiển thị danh sách ghế theo phòng
     */
    public function index(Request $request)
    {
        $phongChieus = PhongChieu::all();
        $phong_id = $request->get('phong_id');
        
        $ghes = collect();
        $phongChieu = null;
        
        if ($phong_id) {
            $phongChieu = PhongChieu::findOrFail($phong_id);
            $ghes = GheNgoi::where('phong_id', $phong_id)->orderBy('so_ghe')->get();
        }
        
        return view('admin.ghengoi.index', compact('phongChieus', 'ghes', 'phong_id', 'phongChieu'));
    }

    /**
     * Hiển thị form tạo ghế
     */
    public function create()
    {
        $phongChieus = PhongChieu::all();
        return view('admin.ghengoi.create', compact('phongChieus'));
    }

    /**
     * Tạo ghế tự động cho phòng
     */
    public function autoGenerate(Request $request)
    {
        $validated = $request->validate([
            'phong_id' => 'required|exists:phong_chieu,phong_id',
            'so_hang' => 'required|integer|min:1|max:20',
            'so_ghe_moi_hang' => 'required|integer|min:1|max:30',
        ]);

        $phong_id = $validated['phong_id'];
        $soHang = $validated['so_hang'];
        $soGheMoiHang = $validated['so_ghe_moi_hang'];

        // Xóa ghế cũ nếu có
        GheNgoi::where('phong_id', $phong_id)->delete();

        // Tạo ghế mới
        $ghes = [];
        for ($hang = 0; $hang < $soHang; $hang++) {
            $hangChu = chr(65 + $hang); // A, B, C, D...
            
            for ($ghe = 1; $ghe <= $soGheMoiHang; $ghe++) {
                $so_ghe = $hangChu . $ghe; // A1, A2, B1, B2...
                $ghe_id = $phong_id . '-' . $so_ghe;
                
                $ghes[] = [
                    'ghe_id' => $ghe_id,
                    'phong_id' => $phong_id,
                    'so_ghe' => $so_ghe,
                ];
            }
        }

        GheNgoi::insert($ghes);

        return redirect()->route('admin.ghengoi.index', ['phong_id' => $phong_id])
            ->with('success', 'Tạo ghế tự động thành công! Tổng: ' . count($ghes) . ' ghế');
    }

    /**
     * Lưu ghế mới (tạo thủ công)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phong_id' => 'required|exists:phong_chieu,phong_id',
            'so_ghe' => 'required|string|max:10',
        ]);

        $ghe_id = $validated['phong_id'] . '-' . $validated['so_ghe'];

        // Kiểm tra trùng
        if (GheNgoi::where('ghe_id', $ghe_id)->exists()) {
            return back()->with('error', 'Ghế này đã tồn tại!');
        }

        GheNgoi::create([
            'ghe_id' => $ghe_id,
            'phong_id' => $validated['phong_id'],
            'so_ghe' => $validated['so_ghe'],
        ]);

        return redirect()->route('admin.ghengoi.index', ['phong_id' => $validated['phong_id']])
            ->with('success', 'Thêm ghế thành công!');
    }

    /**
     * Xóa ghế
     */
    public function destroy($ghe_id)
    {
        $ghe = GheNgoi::findOrFail($ghe_id);
        $phong_id = $ghe->phong_id;
        $ghe->delete();

        return redirect()->route('admin.ghengoi.index', ['phong_id' => $phong_id])
            ->with('success', 'Xóa ghế thành công!');
    }
}
