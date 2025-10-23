<?php

namespace App\Http\Controllers;

use App\Models\Ve;
use App\Models\ChiTietVe;
use App\Models\SuatChieu;
use App\Models\ChiTietVeTamThoi;
use App\Models\VeTamThoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        // Session::forget('ve_id');
        $request->validate([
            'suat_chieu_id' => 'required|exists:suat_chieu,suat_chieu_id',
            'ghe_ids' => 'required|array|min:1',
            'ghe_ids.*' => 'exists:ghe_ngoi,ghe_id',
        ]);

        $suatChieuId = $request->suat_chieu_id;
        $gheIds = $request->ghe_ids;
        $suatChieu = SuatChieu::find($suatChieuId);
        $tongTien = count($gheIds) * $suatChieu->gia_ve;
        $veId = 've' . str_pad(VeTamThoi::count() + 1, 3, '0', STR_PAD_LEFT);

        VeTamThoi::create([
            've_id' => $veId,
            'nguoi_dung_id' => 'nd002',
            'suat_chieu_id' => $suatChieuId,
            'thoi_gian_dat' => now(),
            'tong_tien' => $tongTien,
        ]);

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

    public function TaoVe_ChiTietVe()
    {
        // $ve_id = Session::get('ve_id');

        // $ve_tam_thoi = VeTamThoi::where('ve_id', $ve_id)->first();
        // $danh_sach_ghe_tam = ChiTietVeTamThoi::where('ve_id', $ve_id)->get();

        // if ($ve_tam_thoi) {
        //     Ve::create([
        //         've_id' => $ve_tam_thoi->ve_id,
        //         'nguoi_dung_id' => $ve_tam_thoi->nguoi_dung_id,
        //         'suat_chieu_id' => $ve_tam_thoi->suat_chieu_id,
        //         'thoi_gian_dat' => $ve_tam_thoi->thoi_gian_dat,
        //         'tong_tien' => $ve_tam_thoi->tong_tien,
        //     ]);

        //     foreach ($danh_sach_ghe_tam as $chiTiet) {
        //         ChiTietVe::create([
        //             've_id' => $chiTiet->ve_id,
        //             'ghe_id' => $chiTiet->ghe_id,
        //         ]);
        //     }

        //     $ve_tam_thoi->delete();
        //     ChiTietVeTamThoi::where('ve_id', $ve_id)->delete();
        // }
    }

    public function xuLySauThanhToan(Request $request)
    {
        // Lấy tất cả dữ liệu MoMo trả về
        $data = $request->all();

        // Kiểm tra mã kết quả thanh toán
        if (isset($data['resultCode']) && $data['resultCode'] == 0) {
            // ✅ Thành công
            // Lấy ve_id từ session (nếu bạn lưu khi tạo thanh toán)
            $veId = session('ve_id');

            if ($veId) {
                // Tìm dữ liệu tạm trong DB
                $veTam = VeTamThoi::find($veId);
                $suatChieuId = $veTam->suat_chieu_id;
                $tongTien = $veTam->tong_tien;
                if ($veTam) {
                    // Tạo vé chính thức
                    Ve::create([
                        've_id' => $veId,
                        'nguoi_dung_id' => 'nd002',
                        'suat_chieu_id' => $suatChieuId,
                        'thoi_gian_dat' => now(),
                        'tong_tien' => $tongTien,
                    ]);

                    // Xóa vé tạm
                    $veTam->delete();

                    // Xóa session
                    session()->forget('ve_id');
                }
            }

            return view('phim.ketqua', [
                'thanh_cong' => true,
                'message' => 'Thanh toán thành công!',
                'data' => $data
            ]);
        } else {
            // ❌ Thất bại hoặc hủy
            return view('phim.ketqua', [
                'thanh_cong' => false,
                'message' => 'Thanh toán thất bại hoặc bị hủy!',
                'data' => $data
            ]);
        }
    }
}
