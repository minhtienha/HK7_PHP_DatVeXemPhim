<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;



class NguoiDungController extends Controller
{
    public function index()
    {
        $users = NguoiDung::all();
        return view('nguoi_dung.index', compact('users'));
    }

    public function show($id)
    {
        $user = NguoiDung::find($id);
        return view('nguoi_dung.show', compact('user'));
    }
    public function showProfile()
    {
        // Lấy thông tin của người dùng hiện tại
        $user = Auth::user();
        return view('nguoi_dung.profile', compact('user'));
    }

    // Phương thức xử lý cập nhật thông tin
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'ho_ten' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                // Đảm bảo email là duy nhất, nhưng bỏ qua email của chính người dùng đó
                Rule::unique('nguoi_dung')->ignore($user->nguoi_dung_id, 'nguoi_dung_id'),
            ],
            'so_dien_thoai' => [
                'required',
                'string',
                'max:15',
                // Tương tự, bỏ qua số điện thoại của chính người dùng đó
                Rule::unique('nguoi_dung')->ignore($user->nguoi_dung_id, 'nguoi_dung_id'),
            ],
            'mat_khau_moi' => 'nullable|string|min:6', // Tên field mới cho mật khẩu
        ]);

        $user->ho_ten = $request->ho_ten;
        $user->email = $request->email;
        $user->so_dien_thoai = $request->so_dien_thoai;

        // Chỉ cập nhật mật khẩu nếu có nhập mật khẩu mới
        if ($request->filled('mat_khau_moi')) {
            $user->mat_khau = Hash::make($request->mat_khau_moi);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Cập nhật thông tin thành công!');
    }

    // Hiển thị danh sách vé đã đặt của người dùng
    public function showTickets()
    {
        $user = Auth::user();
        $tickets = $user->ve()
            ->with(['suatChieu.phim', 'suatChieu.phongChieu', 'gheNgoi'])
            ->orderBy('thoi_gian_dat', 'desc')
            ->paginate(10);

        return view('nguoi_dung.tickets', compact('tickets'));
    }

    // Hiển thị danh sách đánh giá của người dùng
    public function showReviews()
    {
        $user = Auth::user();
        $reviews = $user->danhGiaPhim()
            ->with('phim')
            ->orderBy('ngay_tao', 'desc')
            ->paginate(10);

        return view('nguoi_dung.reviews', compact('reviews'));
    }
}
