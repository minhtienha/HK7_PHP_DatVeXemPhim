<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Phim;
use App\Models\TheLoai;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPhimController extends Controller
{
    /**
     * Hiển thị danh sách phim
     */
    public function index(Request $request)
    {
        $query = Phim::with('theLoais');

        // Tìm kiếm theo tên phim
        if ($request->has('search') && $request->search != '') {
            $query->where('ten_phim', 'like', '%' . $request->search . '%')
                ->orWhere('dao_dien', 'like', '%' . $request->search . '%');
        }

        // Lọc theo trạng thái
        if ($request->has('trang_thai') && $request->trang_thai != '') {
            $query->where('trang_thai', $request->trang_thai);
        }

        $phims = $query->paginate(10)->appends($request->all());
        return view('admin.phim.index', compact('phims'));
    }

    /**
     * Hiển thị form tạo phim mới
     */
    public function create()
    {
        $theLoais = TheLoai::all();
        return view('admin.phim.create', compact('theLoais'));
    }

    /**
     * Lưu phim mới vào database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_phim' => 'required|string|max:200',
            'mo_ta' => 'nullable|string',
            'dao_dien' => 'nullable|string|max:100',
            'dien_vien' => 'nullable|string|max:255',
            'thoi_luong' => 'nullable|integer|min:1',
            'ngay_cong_chieu' => 'nullable|date',
            'trang_thai' => 'required|in:dang_chieu,sap_chieu,ngung_chieu',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'the_loai' => 'nullable|array',
        ]);

        // Tạo phim_id tự động (ví dụ: PHIM001, PHIM002...)
        $lastPhim = Phim::orderBy('phim_id', 'desc')->first();
        if ($lastPhim) {
            // Lấy số cuối cùng bất kể prefix (PHIM001, p001, ...)
            if (preg_match('/(\d{3})$/', $lastPhim->phim_id, $matches)) {
                $lastNumber = (int)$matches[1];
            } else {
                $lastNumber = 0;
            }
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $phim_id = 'p' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Xử lý upload ảnh
        $imageName = null;
        if ($request->hasFile('hinh_anh')) {
            $image = $request->file('hinh_anh');
            $imageName = time() . '_' . $phim_id . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets'), $imageName);
        }

        $phim = new Phim();
        $phim->phim_id = $phim_id;
        $phim->ten_phim = $validated['ten_phim'];
        $phim->mo_ta = $validated['mo_ta'];
        $phim->dao_dien = $validated['dao_dien'];
        $phim->dien_vien = $validated['dien_vien'];
        $phim->thoi_luong = $validated['thoi_luong'];
        $phim->ngay_cong_chieu = $validated['ngay_cong_chieu'];
        $phim->trang_thai = $validated['trang_thai'];
        $phim->hinh_anh = $imageName;
        $phim->save();

        // Gắn thể loại cho phim
        if ($request->has('the_loai')) {
            $phim->theLoais()->sync($request->the_loai);
        }

        return redirect()->route('admin.phim.index')->with('success', 'Thêm phim thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa phim
     */
    public function edit($phim_id)
    {
        $phim = Phim::with('theLoais')->findOrFail($phim_id);
        $theLoais = TheLoai::all();
        $selectedTheLoais = $phim->theLoais->pluck('the_loai_id')->toArray();

        return view('admin.phim.edit', compact('phim', 'theLoais', 'selectedTheLoais'));
    }

    /**
     * Cập nhật thông tin phim
     */
    public function update(Request $request, $phim_id)
    {
        $validated = $request->validate([
            'ten_phim' => 'required|string|max:200',
            'mo_ta' => 'nullable|string',
            'dao_dien' => 'nullable|string|max:100',
            'dien_vien' => 'nullable|string|max:255',
            'thoi_luong' => 'nullable|integer|min:1',
            'ngay_cong_chieu' => 'nullable|date',
            'trang_thai' => 'required|in:dang_chieu,sap_chieu,ngung_chieu',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'the_loai' => 'nullable|array',
        ]);

        $phim = Phim::findOrFail($phim_id);

        // Xử lý upload ảnh mới (nếu có)
        if ($request->hasFile('hinh_anh')) {
            // Xóa ảnh cũ nếu có
            if ($phim->hinh_anh && file_exists(public_path('assets/' . $phim->hinh_anh))) {
                unlink(public_path('assets/' . $phim->hinh_anh));
            }

            $image = $request->file('hinh_anh');
            $imageName = time() . '_' . $phim_id . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets'), $imageName);
            $phim->hinh_anh = $imageName;
        }

        $phim->ten_phim = $validated['ten_phim'];
        $phim->mo_ta = $validated['mo_ta'];
        $phim->dao_dien = $validated['dao_dien'];
        $phim->dien_vien = $validated['dien_vien'];
        $phim->thoi_luong = $validated['thoi_luong'];
        $phim->ngay_cong_chieu = $validated['ngay_cong_chieu'];
        $phim->trang_thai = $validated['trang_thai'];
        $phim->save();

        // Cập nhật thể loại
        if ($request->has('the_loai')) {
            $phim->theLoais()->sync($request->the_loai);
        } else {
            $phim->theLoais()->detach();
        }

        return redirect()->route('admin.phim.index')->with('success', 'Cập nhật phim thành công!');
    }

    /**
     * Xóa phim
     */
    public function destroy($phim_id)
    {
        $phim = Phim::findOrFail($phim_id);
        $phim->delete();

        return redirect()->route('admin.phim.index')->with('success', 'Xóa phim thành công!');
    }
}
