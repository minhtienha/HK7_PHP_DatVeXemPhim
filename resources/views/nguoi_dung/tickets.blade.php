@extends('layouts.app')

@section('title', 'Vé Đã Đặt')

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
    .ticket-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        transition: all 0.3s;
        overflow: hidden;
    }
    .ticket-card:hover {
        border-color: #c41e3a;
        box-shadow: 0 4px 15px rgba(196, 30, 58, 0.15);
        transform: translateY(-2px);
    }
    .ticket-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 15px;
        border-bottom: 2px dashed #dee2e6;
    }
    .ticket-body {
        padding: 20px;
    }
    .ticket-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }
    .ticket-info-item i {
        color: #c41e3a;
        margin-right: 10px;
        width: 20px;
    }
    .seat-badge {
        display: inline-block;
        background: #c41e3a;
        color: white;
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 13px;
        margin: 2px;
        font-weight: 500;
    }
</style>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('phim.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile') }}">Hồ Sơ</a></li>
            <li class="breadcrumb-item active">Vé đã đặt</li>
        </ol>
    </nav>

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
                        <a href="{{ route('profile') }}" class="profile-menu-link">
                            <i class="bi bi-person"></i>
                            <span>Thông tin cá nhân</span>
                        </a>
                    </li>
                    <li class="profile-menu-item">
                        <a href="{{ route('profile.tickets') }}" class="profile-menu-link active">
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
                        <i class="bi bi-ticket-perforated-fill" style="color: #c41e3a;"></i> Vé đã đặt
                    </h2>

                    @if($tickets->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-ticket-perforated" style="font-size: 80px; color: #dee2e6;"></i>
                            <h4 class="mt-3 text-muted">Chưa có vé nào</h4>
                            <p class="text-muted">Bạn chưa đặt vé phim nào. Hãy khám phá các phim đang chiếu!</p>
                            <a href="{{ route('phim.index') }}" class="btn btn-primary mt-3" style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); border: none;">
                                <i class="bi bi-film"></i> Xem phim
                            </a>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach($tickets as $ticket)
                                <div class="col-12">
                                    <div class="ticket-card">
                                        <div class="ticket-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="fw-bold mb-0">
                                                    <i class="bi bi-film" style="color: #c41e3a;"></i>
                                                    {{ $ticket->suatChieu->phim->ten_phim }}
                                                </h5>
                                                <span class="badge bg-success text-white">Đã thanh toán</span>
                                            </div>
                                        </div>
                                        <div class="ticket-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="ticket-info-item">
                                                        <i class="bi bi-calendar-event"></i>
                                                        <span><strong>Ngày chiếu:</strong> {{ \Carbon\Carbon::parse($ticket->suatChieu->ngay_chieu)->format('d/m/Y') }}</span>
                                                    </div>
                                                    <div class="ticket-info-item">
                                                        <i class="bi bi-clock"></i>
                                                        <span><strong>Giờ chiếu:</strong> {{ \Carbon\Carbon::parse($ticket->suatChieu->gio_bat_dau)->format('H:i') }} - {{ \Carbon\Carbon::parse($ticket->suatChieu->gio_ket_thuc)->format('H:i') }}</span>
                                                    </div>
                                                    <div class="ticket-info-item">
                                                        <i class="bi bi-door-open"></i>
                                                        <span><strong>Phòng chiếu:</strong> {{ $ticket->suatChieu->phongChieu->ten_phong }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="ticket-info-item">
                                                        <i class="bi bi-receipt"></i>
                                                        <span><strong>Mã vé:</strong> {{ $ticket->ve_id }}</span>
                                                    </div>
                                                    <div class="ticket-info-item">
                                                        <i class="bi bi-calendar-check"></i>
                                                        <span><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($ticket->thoi_gian_dat)->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                    <div class="ticket-info-item">
                                                        <i class="bi bi-cash-coin"></i>
                                                        <span><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($ticket->tong_tien, 0, ',', '.') }}đ</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-3">
                                            <div>
                                                <strong><i class="bi bi-grid-3x3-gap" style="color: #c41e3a;"></i> Ghế đã đặt:</strong>
                                                <div class="mt-2">
                                                    @foreach($ticket->gheNgoi as $ghe)
                                                        <span class="seat-badge">{{ $ghe->so_ghe }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $tickets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
