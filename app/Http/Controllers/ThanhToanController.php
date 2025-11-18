<?php

namespace App\Http\Controllers;

use App\Models\VeTamThoi;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        //execute post
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        if ($curlError) {
            Log::error('cURL Error:', ['error' => $curlError, 'url' => $url]);
        }

        Log::info('cURL Response:', ['http_code' => $httpCode, 'result' => $result]);

        //close connection
        curl_close($ch);

        return $result;
    }

    public function momo_payment(Request $request)
    {
        // Lấy cấu hình Momo từ config
        $env = config('momo.environment', 'test');
        $momoConfig = config("momo.{$env}");

        $endpoint = $momoConfig['endpoint'];
        $partnerCode = $momoConfig['partner_code'];
        $accessKey = $momoConfig['access_key'];
        $secretKey = $momoConfig['secret_key'];

        // Get base URL (dùng config hoặc biến môi trường để dễ thay đổi)
        $baseUrl = env('APP_URL', 'http://localhost:8000');

        $orderInfo = "Thanh toán qua ATM MoMo";
        $veTamThoi = VeTamThoi::orderBy('thoi_gian_dat', 'desc')->first();

        if (!$veTamThoi) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin vé. Vui lòng thử lại.');
        }

        $amount = (int)$veTamThoi->tong_tien ?? 0;
        $orderId = time() . "";

        // URLs với base URL động
        $redirectUrl = $baseUrl . "/ketqua";
        $ipnUrl = $baseUrl . "/tao_ve";
        $extraData = base64_encode(json_encode(['ve_id' => $veTamThoi->ve_id ?? '']));

        $requestId = time() . "";
        $requestType = "payWithMethod";

        // HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => config('momo.store_name', 'Rạp chiếu 4T'),
            "storeId" => config('momo.store_id', '4T_Cinema'),
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

        // Debug: Log kết quả (có thể xóa sau)
        Log::info('Momo Response:', ['result' => $jsonResult, 'raw_result' => $result, 'request_data' => $data]);

        if (!$jsonResult || !isset($jsonResult['payUrl'])) {
            $errorMsg = isset($jsonResult['message']) ? $jsonResult['message'] : 'Không thể tạo liên kết thanh toán. Vui lòng thử lại.';
            Log::error('Momo Payment Error:', [
                'error' => $errorMsg,
                'response' => $jsonResult,
                'raw_result' => $result
            ]);
            return redirect()->back()->with('error', $errorMsg);
        }

        return redirect()->to($jsonResult['payUrl']);
    }
}
