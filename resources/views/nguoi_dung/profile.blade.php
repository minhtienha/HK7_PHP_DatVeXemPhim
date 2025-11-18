@extends('layouts.app')

@section('title', 'Hồ Sơ Cá Nhân')

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('phim.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Hồ Sơ</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-4"><i class="bi bi-person" style="color: #c41e3a;"></i> Thông Tin Cá Nhân</h2>
                <a href="/" class="text-lg font-semibold text-gray-700 hover:text-black">Trang chủ</a>
                    <form action="{{ route('profile') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="ho_ten" class="form-label">Họ và tên</label>
                            <input type="text" id="ho_ten" name="ho_ten" value="{{ Auth::user()->ho_ten }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="tel" id="so_dien_thoai" name="so_dien_thoai" value="{{ Auth::user()->so_dien_thoai }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="mat_khau_moi" class="form-label">Mật khẩu mới</label>
                            <input type="password" id="mat_khau_moi" name="mat_khau_moi" placeholder="Để trống nếu không muốn đổi" class="form-control">
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn fw-bold" style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); color: white; border: none;">
                                <i class="bi bi-check-circle"></i> Lưu Thay Đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection