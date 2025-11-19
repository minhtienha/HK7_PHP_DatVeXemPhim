@extends('layouts.app')

@section('title', 'Hồ Sơ Cá Nhân')

@section('content')
<style>
    .profile-sidebar {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: white;
        font-weight: bold;
        margin: 0 auto 15px;
    }
    .profile-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .profile-menu-item {
        border-bottom: 1px solid #f0f0f0;
    }
    .profile-menu-item:last-child {
        border-bottom: none;
    }
    .profile-menu-link {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s;
    }
    .profile-menu-link:hover {
        background: #f8f9fa;
        color: #c41e3a;
    }
    .profile-menu-link.active {
        background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%);
        color: white !important;
    }
    .profile-menu-link i {
        margin-right: 12px;
        font-size: 18px;
        width: 24px;
    }
</style>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('phim.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Hồ Sơ</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- Avatar & Info -->
                <div class="text-center p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->ho_ten, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ Auth::user()->ho_ten }}</h5>
                    <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                </div>

                <!-- Menu -->
                <ul class="profile-menu">
                    <li class="profile-menu-item">
                        <a href="{{ route('profile') }}" class="profile-menu-link active">
                            <i class="bi bi-person"></i>
                            <span>Thông tin cá nhân</span>
                        </a>
                    </li>
                    <li class="profile-menu-item">
                        <a href="{{ route('profile.tickets') }}" class="profile-menu-link">
                            <i class="bi bi-ticket-perforated"></i>
                            <span>Vé đã đặt</span>
                        </a>
                    </li>
                    <li class="profile-menu-item">
                        <a href="{{ route('profile.reviews') }}" class="profile-menu-link">
                            <i class="bi bi-star"></i>
                            <span>Đánh giá của tôi</span>
                        </a>
                    </li>
                    <li class="profile-menu-item">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="profile-menu-link w-100 text-start border-0 bg-transparent" style="color: #c41e3a !important;">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Đăng xuất</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-4">
                        <i class="bi bi-person-circle" style="color: #c41e3a;"></i> Thông tin cá nhân
                    </h2>
                    
                    <form action="{{ route('profile') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" 
                                   class="form-control" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ho_ten" class="form-label fw-semibold">Họ và tên</label>
                            <input type="text" id="ho_ten" name="ho_ten" value="{{ Auth::user()->ho_ten }}" 
                                   class="form-control" required>
                            @error('ho_ten')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="so_dien_thoai" class="form-label fw-semibold">Số điện thoại</label>
                            <input type="tel" id="so_dien_thoai" name="so_dien_thoai" 
                                   value="{{ Auth::user()->so_dien_thoai }}" class="form-control" required>
                            @error('so_dien_thoai')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="mat_khau_moi" class="form-label fw-semibold">Mật khẩu</label>
                            <input type="password" id="mat_khau_moi" name="mat_khau_moi" 
                                   placeholder="********" class="form-control">
                            <small class="text-muted">Để trống nếu không muốn đổi mật khẩu</small>
                            @error('mat_khau_moi')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn fw-bold px-4 py-2" 
                                    style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); color: white; border: none;">
                                <i class="bi bi-check-circle"></i> Chỉnh sửa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection