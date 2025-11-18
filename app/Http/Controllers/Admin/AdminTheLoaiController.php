<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TheLoai;
use Illuminate\Http\Request;

class AdminTheLoaiController extends Controller
{
    /**
     * Hiển thị danh sách thể loại
     */
    public function index(Request $request)
    {
        $query = TheLoai::query();

        // Tìm kiếm theo tên thể loại
        if ($request->has('search') && $request->search != '') {
            $query->where('ten_the_loai', 'like', '%' . $request->search . '%');
        }

        $theLoais = $query->paginate(15)->appends($request->all());
        return view('admin.theloai.index', compact('theLoais'));
    }

    /**
     * Hiển thị form tạo thể loại mới
     */
    public function create()
    {
        return view('admin.theloai.create');
    }

    /**
     * Lưu thể loại mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_the_loai' => 'required|string|max:100|unique:the_loai,ten_the_loai',
        ]);

        // Tạo the_loai_id tự động (ví dụ: tl001, tl002...)
        $lastTheLoai = TheLoai::orderBy('the_loai_id', 'desc')->first();
        if ($lastTheLoai) {
            $lastNumber = (int) substr($lastTheLoai->the_loai_id, 2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $the_loai_id = 'tl' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        TheLoai::create([
            'the_loai_id' => $the_loai_id,
            'ten_the_loai' => $validated['ten_the_loai'],
        ]);

        return redirect()->route('admin.theloai.index')->with('success', 'Thêm thể loại thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa thể loại
     */
    public function edit($id)
    {
        $theLoai = TheLoai::findOrFail($id);
        return view('admin.theloai.edit', compact('theLoai'));
    }

    /**
     * Cập nhật thể loại
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ten_the_loai' => 'required|string|max:100|unique:the_loai,ten_the_loai,' . $id . ',the_loai_id',
        ]);

        $theLoai = TheLoai::findOrFail($id);
        $theLoai->update($validated);

        return redirect()->route('admin.theloai.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    /**
     * Xóa thể loại
     */
    public function destroy($id)
    {
        $theLoai = TheLoai::findOrFail($id);
        $theLoai->delete();

        return redirect()->route('admin.theloai.index')->with('success', 'Xóa thể loại thành công!');
    }
}
