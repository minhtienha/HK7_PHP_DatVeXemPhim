<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhongChieu;
use Illuminate\Http\Request;

class AdminPhongChieuController extends Controller
{
    /**
     * Hiển thị danh sách phòng chiếu
     */
    public function index(Request $request)
    {
        $query = PhongChieu::withCount('gheNgoi');

        // Tìm kiếm theo tên phòng
        if ($request->has('search') && $request->search != '') {
            $query->where('ten_phong', 'like', '%' . $request->search . '%');
        }

        $phongChieus = $query->paginate(10)->appends($request->all());
        return view('admin.phongchieu.index', compact('phongChieus'));
    }

    /**
     * Hiển thị form tạo phòng chiếu mới
     */
    public function create()
    {
        return view('admin.phongchieu.create');
    }

    /**
     * Lưu phòng chiếu mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_phong' => 'required|string|max:50|unique:phong_chieu,ten_phong',
            'suc_chua' => 'required|integer|min:1|max:500',
        ], [
            'ten_phong.required' => 'Tên phòng không được để trống',
            'ten_phong.unique' => 'Tên phòng đã tồn tại',
            'suc_chua.required' => 'Sức chứa không được để trống',
            'suc_chua.integer' => 'Sức chứa phải là số nguyên',
            'suc_chua.min' => 'Sức chứa phải lớn hơn 0',
            'suc_chua.max' => 'Sức chứa không được vượt quá 500',
        ]);

        // Tạo phong_id tự động (ví dụ: pc001, pc002...)
        $lastPhong = PhongChieu::orderBy('phong_id', 'desc')->first();
        if ($lastPhong) {
            $lastNumber = (int) substr($lastPhong->phong_id, 2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $phong_id = 'pc' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        PhongChieu::create([
            'phong_id' => $phong_id,
            'ten_phong' => $validated['ten_phong'],
            'suc_chua' => $validated['suc_chua'],
        ]);

        return redirect()->route('admin.phongchieu.index')->with('success', 'Thêm phòng chiếu thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa phòng chiếu
     */
    public function edit($phong_id)
    {
        $phongChieu = PhongChieu::findOrFail($phong_id);
        return view('admin.phongchieu.edit', compact('phongChieu'));
    }

    /**
     * Cập nhật phòng chiếu
     */
    public function update(Request $request, $phong_id)
    {
        $validated = $request->validate([
            'ten_phong' => 'required|string|max:100',
            'suc_chua' => 'required|integer|min:1|max:500',
        ]);

        $phongChieu = PhongChieu::findOrFail($phong_id);
        $phongChieu->update($validated);

        return redirect()->route('admin.phongchieu.index')->with('success', 'Cập nhật phòng chiếu thành công!');
    }

    /**
     * Xóa phòng chiếu
     */
    public function destroy($phong_id)
    {
        $phongChieu = PhongChieu::findOrFail($phong_id);
        $phongChieu->delete();

        return redirect()->route('admin.phongchieu.index')->with('success', 'Xóa phòng chiếu thành công!');
    }
}
