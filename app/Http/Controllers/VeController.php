<?php

namespace App\Http\Controllers;

use App\Models\Ve;
use App\Models\ChiTietVe;
use App\Models\SuatChieu;
use App\Models\ChiTietVeTamThoi;
use App\Models\VeTamThoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class VeController extends Controller
{
    public function index()
    {
        $ves = Ve::all();
        return view('ve.index', compact('ves'));
    }

    public function show($id)
    {
        $ve = Ve::with('chiTietVe.ghe')->find($id);
        return view('pages.bookingDetail', compact('ve'));
    }

    public function HienThiGheChoSC($suat_chieu_id)
    {
        $suatChieu = SuatChieu::with('phim', 'phongChieu.gheNgoi')->find($suat_chieu_id);

        $gheDaDat = Ve::where('suat_chieu_id', $suat_chieu_id)
            ->whereNotNull('thoi_gian_dat')
            ->join('chi_tiet_ve', 've.ve_id', '=', 'chi_tiet_ve.ve_id')
            ->pluck('chi_tiet_ve.ghe_id')
            ->toArray();

        $gheTrongPhong = $suatChieu->phongChieu->gheNgoi ?? collect();

        return view('pages.booking', compact('suatChieu', 'gheTrongPhong', 'gheDaDat'));
    }

    public function LuuVeTamThoi(Request $request)
    {
        // Kiểm tra đã đăng nhập
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt vé');
        }

        $request->validate([
            'suat_chieu_id' => 'required|exists:suat_chieu,suat_chieu_id',
            'ghe_ids' => 'required|array|min:1',
            'ghe_ids.*' => 'exists:ghe_ngoi,ghe_id',
        ]);

        $suatChieuId = $request->suat_chieu_id;
        $gheIds = $request->ghe_ids;
        $suatChieu = SuatChieu::find($suatChieuId);
        $tongTien = count($gheIds) * $suatChieu->gia_ve;

        // Xóa vé tạm thời cũ của người dùng này (nếu có) để tránh duplicate
        $veTamCu = VeTamThoi::where('nguoi_dung_id', $user->nguoi_dung_id)->get();
        foreach ($veTamCu as $veTam) {
            ChiTietVeTamThoi::where('ve_id', $veTam->ve_id)->delete();
            $veTam->delete();
        }

        // Tạo mã vé unique bằng timestamp + random để tránh conflict khi nhiều user cùng lúc
        // Format: ve_YYYYMMDDHHMMSS_XXXX (ví dụ: ve_20251204153045_A3F2)
        do {
            $veId = 've_' . date('YmdHis') . '_' . strtoupper(substr(uniqid(), -4));
            // Kiểm tra xem mã vé đã tồn tại chưa (rất hiếm xảy ra)
            $exists = Ve::where('ve_id', $veId)->exists() || VeTamThoi::where('ve_id', $veId)->exists();
        } while ($exists);

        VeTamThoi::create([
            've_id' => $veId,
            'nguoi_dung_id' => $user->nguoi_dung_id,
            'suat_chieu_id' => $suatChieuId,
            'thoi_gian_dat' => now(),
            'tong_tien' => $tongTien,
        ]);

        // Tạo chi tiết vé tạm thời
        foreach ($gheIds as $gheId) {
            ChiTietVeTamThoi::create([
                've_id' => $veId,
                'ghe_id' => $gheId,
            ]);
        }

        Session::put('ve_id', $veId);

        return redirect()->route('chi_tiet_ve_tam_thoi', ['ve_id' => $veId]);
    }

    public function ChiTietVeTamThoi($ve_id)
    {
        $ve_tam_thoi = VeTamThoi::where('ve_id', $ve_id)->first();
        $danh_sach_ghe_tam = ChiTietVeTamThoi::where('ve_id', $ve_id)->get();

        return view('pages.bookingDetail', compact('ve_tam_thoi', 'danh_sach_ghe_tam'));
    }

    public function TaoVe_ChiTietVe(Request $request)
    {
        // Lấy ve_id từ extraData được gửi từ Momo
        $extraData = $request->input('extraData');
        $veId = null;

        if ($extraData) {
            $decoded = json_decode(base64_decode($extraData), true);
            $veId = $decoded['ve_id'] ?? null;
        }

        if (!$veId) {
            $veId = session('ve_id');
        }

        if (!$veId) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy vé'], 400);
        }

        $veTam = VeTamThoi::find($veId);
        if (!$veTam) {
            return response()->json(['status' => 'error', 'message' => 'Vé không tồn tại'], 404);
        }

        try {
            // Check xem vé đã được tạo chưa để tránh duplicate
            $veExist = Ve::find($veId);

            if (!$veExist) {
                // Tạo vé chính thức
                Ve::create([
                    've_id' => $veId,
                    'nguoi_dung_id' => $veTam->nguoi_dung_id,
                    'suat_chieu_id' => $veTam->suat_chieu_id,
                    'thoi_gian_dat' => $veTam->thoi_gian_dat,
                    'tong_tien' => $veTam->tong_tien,
                ]);

                // Sao chép chi tiết vé từ tạm sang chính
                $chiTietTam = ChiTietVeTamThoi::where('ve_id', $veId)->get();
                foreach ($chiTietTam as $item) {
                    ChiTietVe::create([
                        've_id' => $item->ve_id,
                        'ghe_id' => $item->ghe_id,
                    ]);
                }

                // Xóa dữ liệu tạm
                $veTam->delete();
                ChiTietVeTamThoi::where('ve_id', $veId)->delete();
            }

            // Xóa session
            session()->forget('ve_id');

            return response()->json(['status' => 'success', 'message' => 'Vé được tạo thành công']);
        } catch (\Exception $e) {
            Log::error('Lỗi tạo vé:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Lỗi tạo vé: ' . $e->getMessage()], 500);
        }
    }

    public function xuLySauThanhToan(Request $request)
    {
        // Lấy tất cả dữ liệu MoMo trả về
        $data = $request->all();

        // Kiểm tra mã kết quả thanh toán
        if (isset($data['resultCode']) && $data['resultCode'] == 0) {
            // Thanh toán thành công
            $veId = session('ve_id');

            if (!$veId) {
                // Cố gắng lấy từ extraData
                $extraData = $data['extraData'] ?? null;
                if ($extraData) {
                    $decoded = json_decode(base64_decode($extraData), true);
                    $veId = $decoded['ve_id'] ?? null;
                }
            }

            if ($veId) {
                $veTam = VeTamThoi::find($veId);
                if ($veTam) {
                    // Check xem vé đã được tạo chưa để tránh duplicate
                    $veExist = Ve::find($veId);

                    if (!$veExist) {
                        // Tạo vé chính thức
                        Ve::create([
                            've_id' => $veId,
                            'nguoi_dung_id' => $veTam->nguoi_dung_id,
                            'suat_chieu_id' => $veTam->suat_chieu_id,
                            'thoi_gian_dat' => $veTam->thoi_gian_dat,
                            'tong_tien' => $veTam->tong_tien,
                        ]);

                        // Sao chép chi tiết vé từ tạm sang chính
                        $chiTietTam = ChiTietVeTamThoi::where('ve_id', $veId)->get();
                        foreach ($chiTietTam as $item) {
                            ChiTietVe::create([
                                've_id' => $item->ve_id,
                                'ghe_id' => $item->ghe_id,
                            ]);
                        }

                        // Xóa vé tạm
                        $veTam->delete();
                        ChiTietVeTamThoi::where('ve_id', $veId)->delete();
                    }

                    session()->forget('ve_id');
                }
            }

            return view('phim.ketqua', [
                'thanh_cong' => true,
                'message' => 'Thanh toán thành công!',
                'data' => $data
            ]);
        } else {
            // Thanh toán thất bại hoặc bị hủy
            return view('phim.ketqua', [
                'thanh_cong' => false,
                'message' => 'Thanh toán thất bại hoặc bị hủy!',
                'data' => $data
            ]);
        }
    }
}
