<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:nguoi_dung,email'],
            'so_dien_thoai' => ['required', 'string', 'max:15', 'unique:nguoi_dung,so_dien_thoai'],
            'mat_khau' => ['required', 'string', 'min:6'],
        ]);

        // Sinh ID an toàn
        $newId = uniqid('nd'); // ví dụ: nd651f5c8a3e0b1

        try {
            NguoiDung::create([
                'nguoi_dung_id' => $newId,
                'ho_ten' => $validatedData['ho_ten'],
                'email' => $validatedData['email'],
                'so_dien_thoai' => $validatedData['so_dien_thoai'],
                'mat_khau' => Hash::make($validatedData['mat_khau']),
                'vai_tro' => 'khach_hang',
            ]);

            return redirect()->route('login')->with('success', 'Đăng ký thành công!');
        } catch (\Illuminate\Database\QueryException $ex) {
            // Nếu vẫn có lỗi duplicate hoặc khác, trả về với thông báo rõ ràng
            return back()->withInput()->with('error', 'Lỗi lưu dữ liệu: ' . $ex->getMessage());
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'email' => ['required', 'email'],
            'mat_khau' => ['required'],
        ]);

        // Chuẩn bị credentials (Laravel expects 'password' key)
        $credentials = [
            'email' => $data['email'],
            'password' => $data['mat_khau'],
        ];

        try {
            if (Auth::attempt($credentials)) {
                // Regenerate session để tránh session fixation
                $request->session()->regenerate();
                // Redirect tới /phim (hoặc dùng intended fallback)
                return redirect()->intended('/phim');
                // hoặc bắt buộc về phim: return redirect('/phim');
                // hoặc bằng tên route: return redirect()->route('phim.index');
            }

            // Nếu thất bại
            return back()
                ->withErrors(['email' => 'Thông tin đăng nhập không hợp lệ.'])
                ->withInput($request->only('email'));
        } catch (\Exception $e) {
            Log::error('Login exception: '.$e->getMessage());
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}