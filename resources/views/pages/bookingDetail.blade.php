@extends('layouts.app')

@section('title', 'Chi tiết vé - ' . $ve_tam_thoi['ve_id'])

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4">Chi tiết vé</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm p-4">
            <h4>Thông tin vé</h4>
            <p><strong>Mã vé:</strong> {{ $ve_tam_thoi['ve_id'] }}</p>
            <p><strong>Người dùng:</strong> {{ $ve_tam_thoi['nguoi_dung_id'] }}</p>
            <p><strong>Suất chiếu:</strong> {{ $ve_tam_thoi['suat_chieu_id'] }}</p>
            <p><strong>Thời gian đặt:</strong> {{ $ve_tam_thoi['thoi_gian_dat'] }}</p>
            <p><strong>Tổng tiền:</strong> {{ number_format($ve_tam_thoi['tong_tien']) }} VNĐ</p>

            <h5 class="mt-4">Danh sách ghế</h5>
            <ul class="list-group">
-                @foreach($danh_sach_ghe_tam as $chiTietGhe)
-                    <li class="list-group-item">{{ $chiTietGhe['ghe_id']}}</li>
-                @endforeach
-            </ul>
        </div>

        <form action="{{route('phuong_thuc_thanh_toan')}}" method="GET">
        @csrf
            <div class="mb-3">
                <label for="diem" class="form-label">Chọn phương thức thanh toán:</label>
                <select name="phuong_thuc" id="phuong_thuc" class="form-select w-auto" required>
                    <option value="momo">Momo</option>
                    <option value="vnpay">VNPay</option>
                </select>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Xác nhận thanh toán</button>
            </div>
            <div class="text-center mt-4">
                <a href="/phim" class="btn btn-danger">Huỷ thanh toán</a>
            </div>
        </form>
    </div>
@endsection
