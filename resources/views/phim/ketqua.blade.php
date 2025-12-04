@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if($thanh_cong)
                <!-- Thành công -->
                <div class="card shadow-lg border-0" style="border-top: 4px solid #28a745;">
                    <div class="card-body p-5 text-center">
                        <div style="font-size: 80px; color: #28a745; margin-bottom: 20px;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h2 class="fw-bold mb-3" style="color: #28a745;">Thanh Toán Thành Công!</h2>
                        <p class="text-muted mb-4" style="font-size: 16px;">
                            Vé của bạn đã được đặt và xác nhận thành công.
                        </p>

                        @if(isset($data['orderId']))
                            <div class="alert alert-light border-1" style="border-color: #28a745;">
                                <p class="mb-2"><strong>Mã đơn hàng:</strong></p>
                                <p class="text-monospace fw-bold" style="font-size: 14px; color: #c41e3a;">{{ $data['orderId'] }}</p>
                            </div>
                        @endif

                        @if(isset($data['amount']))
                            <div class="row mb-4">
                                <div class="col-6">
                                    <p class="text-muted mb-1">Số tiền</p>
                                    <p class="fw-bold" style="font-size: 18px; color: #c41e3a;">
                                        {{ number_format($data['amount']) }} VNĐ
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted mb-1">Phương thức</p>
                                    <p class="fw-bold" style="font-size: 16px;">
                                        <i class="bi bi-wallet2"></i> MoMo
                                    </p>
                                </div>
                            </div>
                        @endif

                        <hr>

                        <div class="d-flex gap-2">
                            <a href="{{ route('phim.index') }}" class="btn btn-primary flex-grow-1" style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); border: none;">
                                <i class="bi bi-house-fill"></i> Về Trang Chủ
                            </a>
                            <a href="{{ route('phim.index') }}" class="btn btn-outline-primary flex-grow-1">
                                <i class="bi bi-film"></i> Xem Phim Khác
                            </a>
                        </div>
                    </div>
                </div>

                {{-- <!-- Thông tin hỗ trợ -->
                <div class="alert alert-info mt-4" style="border-left: 4px solid #0d6efd;">
                    <strong>💡 Gợi ý:</strong> Bạn có thể quản lý vé của mình trong phần "Vé của tôi" hoặc kiểm tra email xác nhận.
                </div> --}}
            @else
                <!-- Thất bại -->
                <div class="card shadow-lg border-0" style="border-top: 4px solid #dc3545;">
                    <div class="card-body p-5 text-center">
                        <div style="font-size: 80px; color: #dc3545; margin-bottom: 20px;">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <h2 class="fw-bold mb-3" style="color: #dc3545;">Thanh Toán Thất Bại!</h2>
                        <p class="text-muted mb-4" style="font-size: 16px;">
                            Rất tiếc, giao dịch thanh toán của bạn không thành công. Vui lòng thử lại.
                        </p>

                        @if(isset($data['message']))
                            <div class="alert alert-warning">
                                <strong>Lý do:</strong> {{ $data['message'] }}
                            </div>
                        @endif

                        <hr>

                        <div class="d-flex gap-2">
                            <a href="javascript:history.back()" class="btn btn-warning flex-grow-1">
                                <i class="bi bi-arrow-left"></i> Quay Lại
                            </a>
                            <a href="{{ route('phim.index') }}" class="btn btn-outline-primary flex-grow-1">
                                <i class="bi bi-house-fill"></i> Về Trang Chủ
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Hỗ trợ -->
                <div class="alert alert-danger mt-4" style="border-left: 4px solid #dc3545;">
                    <strong>⚠️ Cần giúp đỡ?</strong> Vui lòng liên hệ với bộ phận hỗ trợ khách hàng hoặc thử lại sau.
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .text-monospace {
        font-family: 'Monaco', 'Courier New', monospace;
        letter-spacing: 1px;
    }
    
    .bi {
        margin-right: 8px;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>
@endsection
