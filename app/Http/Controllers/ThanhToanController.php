<?php

namespace App\Http\Controllers;

use App\Models\VeTamThoi;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class ThanhToanController extends Controller
{
    public function phuongThucThanhToan(Request $request)
    {
        $request->validate([
            'phuong_thuc' => 'required|string|in:momo,vnpay',
        ]);

        $phuongThuc = $request->phuong_thuc;
        $tongTien = VeTamThoi::orderBy('thoi_gian_dat', 'desc')->first()->tong_tien ?? 0;

        if ($tongTien <= 0) {
            return redirect()->back()->with('error', 'Không có thông tin thanh toán.');
        }

        switch ($phuongThuc) {
            case 'momo':
                return redirect()->route('momo_payment', ['tong_tien' => $tongTien]);

            case 'vnpay':
                return redirect()->route('vnpay_payment', ['tong_tien' => $tongTien]);

            default:
                return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ.');
        }
    }


    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        // Xài mặc định của momo
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';


        $orderInfo = "Thanh toán qua ATM MoMo";
        $veTamThoi = VeTamThoi::orderBy('thoi_gian_dat', 'desc')->first();
        $amount = $veTamThoi->tong_tien ?? 0;
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/phim";
        $ipnUrl = "https://e0dfb7d52bc4.ngrok-free.app/tao_ve";
        $extraData = base64_encode(json_encode(['ve_id' => $veTamThoi->ve_id ?? '']));

        $requestId = time() . "";
        $requestType = "payWithMethod";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Rạp chiếu 4T",
            "storeId" => "4T_Cinema",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        return redirect()->to($jsonResult['payUrl']);
    }
}
