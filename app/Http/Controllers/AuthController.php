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
            'mat_khau' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'ho_ten.required' => 'Họ tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'so_dien_thoai.unique' => 'Số điện thoại đã được sử dụng',
            'mat_khau.required' => 'Mật khẩu không được để trống',
            'mat_khau.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'mat_khau.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        // Tạo nguoi_dung_id tự động
        $lastUser = NguoiDung::orderBy('nguoi_dung_id', 'desc')->first();
        if ($lastUser) {
            $lastNumber = (int) substr($lastUser->nguoi_dung_id, 2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $nguoi_dung_id = 'nd' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        try {
            NguoiDung::create([
                'nguoi_dung_id' => $nguoi_dung_id,
                'ho_ten' => $validatedData['ho_ten'],
                'email' => $validatedData['email'],
                'so_dien_thoai' => $validatedData['so_dien_thoai'],
                'mat_khau' => Hash::make($validatedData['mat_khau']),
                'vai_tro' => 'khach_hang',
            ]);

            return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Illuminate\Database\QueryException $ex) {
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
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'mat_khau.required' => 'Mật khẩu không được để trống',
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

                // Kiểm tra vai trò và redirect phù hợp
                if (Auth::user()->vai_tro === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->intended(route('phim.index'));
            }

            // Nếu thất bại
            return back()
                ->withErrors(['email' => 'Email hoặc mật khẩu không chính xác.'])
                ->withInput($request->only('email'));
        } catch (\Exception $e) {
            Log::error('Login exception: ' . $e->getMessage());
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
