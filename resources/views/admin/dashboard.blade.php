@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">📊 Dashboard</h1>
    
    <div class="row">
        <!-- Thống kê tổng quan -->
        <div class="col-md-4">
            <div class="stat-card bg-primary-custom">
                <p><i class="fas fa-film"></i> Tổng số phim</p>
                <h3>{{ $tongPhim }}</h3>
                <small>{{ $phimDangChieu }} phim đang chiếu</small>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card bg-success-custom">
                <p><i class="fas fa-door-open"></i> Phòng chiếu</p>
                <h3>{{ $tongPhongChieu }}</h3>
                <small>Đang hoạt động</small>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card bg-warning-custom">
                <p><i class="fas fa-clock"></i> Suất chiếu</p>
                <h3>{{ $tongSuatChieu }}</h3>
                <small>{{ $suatChieuHomNay }} suất hôm nay</small>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card bg-info-custom">
                <p><i class="fas fa-users"></i> Người dùng</p>
                <h3>{{ $tongNguoiDung }}</h3>
                <small>Đã đăng ký</small>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card bg-danger-custom">
                <p><i class="fas fa-ticket-alt"></i> Vé đã bán</p>
                <h3>{{ $tongVe }}</h3>
                <small>Tổng số vé</small>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card bg-secondary-custom">
                <p><i class="fas fa-money-bill-wave"></i> Doanh thu</p>
                <h3>{{ number_format($tongDoanhThu, 0, ',', '.') }}đ</h3>
                <small>Tổng doanh thu</small>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line text-primary"></i> Tổng quan hệ thống</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Chào mừng bạn đến với trang quản trị MovieBooking!</p>
                    <p>Sử dụng menu bên trái để quản lý:</p>
                    <ul>
                        <li><strong>Phim:</strong> Thêm, sửa, xóa thông tin phim</li>
                        <li><strong>Thể loại:</strong> Quản lý danh mục thể loại phim</li>
                        <li><strong>Phòng chiếu:</strong> Quản lý các phòng chiếu</li>
                        <li><strong>Ghế:</strong> Tạo và quản lý sơ đồ ghế ngồi</li>
                        <li><strong>Suất chiếu:</strong> Lên lịch chiếu phim</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
