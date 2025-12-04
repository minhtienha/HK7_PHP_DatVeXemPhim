<?php

namespace App\Http\Controllers;

use App\Models\VeTamThoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ThanhToanController extends Controller
{
    /**
     * Xử lý chọn phương thức thanh toán và chuyển hướng
     */
    public function phuongThucThanhToan(Request $request)
    {
        $request->validate([
            'phuong_thuc' => 'required|string|in:momo,vnpay',
        ]);

        // Lấy thông tin vé tạm thời mới nhất (Bạn nên cân nhắc thêm điều kiện user_id nếu có login)
        $veTamThoi = VeTamThoi::orderBy('thoi_gian_dat', 'desc')->first();
        $tongTien = $veTamThoi->tong_tien ?? 0;

        if ($tongTien <= 0) {
            return redirect()->back()->with('error', 'Không có thông tin thanh toán hoặc số tiền không hợp lệ.');
        }

        switch ($request->phuong_thuc) {
            case 'momo':
                // Chuyển hướng đến hàm xử lý thanh toán MoMo
                return redirect()->route('momo_payment');

            case 'vnpay':
                // Chuyển hướng đến route xử lý VNPAY (cần đảm bảo route này đã tồn tại)
                return redirect()->route('vnpay_payment');

            default:
                return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ.');
        }
    }

    /**
     * Hàm hỗ trợ gửi request cURL (Helper function)
     */
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

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        if ($curlError) {
            Log::error('cURL Error:', ['error' => $curlError, 'url' => $url]);
        }

        // Log kết quả cURL để debug (có thể comment lại khi chạy production)
        // Log::info('cURL Response:', ['http_code' => $httpCode, 'result' => $result]);

        curl_close($ch);

        return $result;
    }

    /**
     * Xử lý logic tạo giao dịch thanh toán MoMo
     */
    public function momo_payment(Request $request)
    {
        // 1. Lấy thông tin vé
        $veTamThoi = VeTamThoi::orderBy('thoi_gian_dat', 'desc')->first();

        if (!$veTamThoi) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin vé. Vui lòng thử lại.');
        }

        // 2. Lấy cấu hình Momo
        $env = config('momo.environment', 'test');
        $momoConfig = config("momo.{$env}");

        $endpoint = $momoConfig['endpoint'];
        $partnerCode = $momoConfig['partner_code'];
        $accessKey = $momoConfig['access_key'];
        $secretKey = $momoConfig['secret_key'];

        // 3. QUAN TRỌNG: Lấy Base URL động từ file .env (Để hỗ trợ Ngrok)
        // Đảm bảo trong .env bạn đã set: APP_URL=https://your-ngrok-link.ngrok-free.app
        $baseUrl = config('app.url'); 

        // 4. Chuẩn bị dữ liệu thanh toán
        $orderInfo = "Thanh toán vé xem phim tại Rạp 4T";
        $amount = (int)$veTamThoi->tong_tien;
        $orderId = time() . ""; // Mã đơn hàng unique
        $requestId = time() . "";
        $requestType = "payWithMethod";
        
        // Tạo extraData chứa ve_id để xử lý sau khi thanh toán thành công
        $extraData = base64_encode(json_encode(['ve_id' => $veTamThoi->ve_id ?? '']));

        // 5. Cấu hình các đường dẫn Callback
        // Redirect URL: Nơi User được chuyển về sau khi thanh toán trên app MoMo (Client-side)
        $redirectUrl = $baseUrl . "/ketqua"; 
        
        // IPN URL: Nơi Server MoMo gọi ngầm về Server của bạn để báo kết quả (Server-side)
        // Link này MỚI LÀ LINK QUAN TRỌNG để lưu database
        $ipnUrl = $baseUrl . "/tao_ve";

        // 6. Tạo chữ ký (Signature) theo chuẩn MoMo
        $rawHash = "accessKey=" . $accessKey . 
                   "&amount=" . $amount . 
                   "&extraData=" . $extraData . 
                   "&ipnUrl=" . $ipnUrl . 
                   "&orderId=" . $orderId . 
                   "&orderInfo=" . $orderInfo . 
                   "&partnerCode=" . $partnerCode . 
                   "&redirectUrl=" . $redirectUrl . 
                   "&requestId=" . $requestId . 
                   "&requestType=" . $requestType;

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
            'ipnUrl' => $ipnUrl, // Link ngrok sẽ được điền vào đây
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        // 7. Gửi request sang MoMo
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        // Debug Log: Kiểm tra xem link IPN đã đúng là link ngrok chưa
        Log::info('Momo Request Init:', [
            'ipnUrl' => $ipnUrl, 
            'redirectUrl' => $redirectUrl,
            'orderId' => $orderId
        ]);
        
        // Log kết quả trả về từ MoMo
        // Log::info('Momo Response:', ['result' => $jsonResult]);

        if (!$jsonResult || !isset($jsonResult['payUrl'])) {
            $errorMsg = isset($jsonResult['message']) ? $jsonResult['message'] : 'Lỗi kết nối tới cổng thanh toán MoMo.';
            Log::error('Momo Payment Creation Failed:', [
                'error' => $errorMsg,
                'response' => $jsonResult
            ]);
            return redirect()->back()->with('error', $errorMsg);
        }

        // 8. Chuyển hướng người dùng sang trang thanh toán MoMo
        return redirect()->to($jsonResult['payUrl']);
    }
}