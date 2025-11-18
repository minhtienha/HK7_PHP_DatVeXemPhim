@extends('layouts.app')

@section('title', 'Chi tiết vé - ' . $ve_tam_thoi['ve_id'])

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('phim.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Chi tiết vé</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4" style="color: #c41e3a;">
        Chi tiết vé
    </h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Thông tin vé -->
    <div class="card shadow-lg mb-4" style="border-top: 4px solid #c41e3a;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3" style="color: #c41e3a;">
                <i class="bi bi-info-circle"></i> Thông tin vé
            </h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p class="mb-2">
                        <strong>Mã vé:</strong> 
                        <span class="badge bg-danger">{{ $ve_tam_thoi['ve_id'] }}</span>
                    </p>
                    <p class="mb-2">
                        <strong>Người dùng:</strong> {{ $ve_tam_thoi['nguoi_dung_id'] }}
                    </p>
                    <p class="mb-0">
                        <strong>Thời gian đặt:</strong> {{ date('d/m/Y H:i', strtotime($ve_tam_thoi['thoi_gian_dat'])) }}
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-2">
                        <strong>Suất chiếu:</strong> {{ $ve_tam_thoi['suat_chieu_id'] }}
                    </p>
                    <p class="mb-0">
                        <strong style="font-size: 18px;">Tổng tiền:</strong> 
                        <span style="font-size: 18px; color: #c41e3a; font-weight: bold;">{{ number_format($ve_tam_thoi['tong_tien']) }} VNĐ</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách ghế -->
    <div class="card shadow-lg mb-4" style="border-top: 4px solid #c41e3a;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3" style="color: #c41e3a;">
                <i class="bi bi-chair"></i> Danh sách ghế đã chọn
            </h5>
            @if(count($danh_sach_ghe_tam) > 0)
                <div class="d-flex flex-wrap gap-2">
                    @foreach($danh_sach_ghe_tam as $chiTietGhe)
                        <span class="badge bg-success" style="font-size: 14px; padding: 8px 12px;">
                            <i class="bi bi-check-circle"></i> {{ $chiTietGhe['ghe_id'] }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-muted mb-0">Chưa chọn ghế nào</p>
            @endif
        </div>
    </div>

    <!-- Phương thức thanh toán -->
    <form action="{{ route('phuong_thuc_thanh_toan') }}" method="POST" class="card shadow-lg" style="border-top: 4px solid #c41e3a;">
        @csrf
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4" style="color: #c41e3a;">
                <i class="bi bi-credit-card"></i> Chọn phương thức thanh toán
            </h5>
            <div class="mb-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="momo" value="momo" checked required>
                    <label class="form-check-label" for="momo">
                        <strong>Momo</strong> - Thanh toán qua ví điện tử
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="vnpay" value="vnpay" required>
                    <label class="form-check-label" for="vnpay">
                        <strong>VNPay</strong> - Thanh toán qua cổng VNPay
                    </label>
                </div>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn fw-bold py-2 px-4" 
                        style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); color: white; border: none; flex: 1;">
                    <i class="bi bi-credit-card"></i> Xác nhận thanh toán
                </button>
                <a href="{{ route('phim.index') }}" class="btn btn-outline-danger fw-bold py-2 px-4" style="flex: 1;">
                    <i class="bi bi-x-circle"></i> Huỷ thanh toán
                </a>
            </div>
        </div>
    </form>
</div>

<style>
    .badge {
        font-weight: 500;
    }
</style>
@endsection
