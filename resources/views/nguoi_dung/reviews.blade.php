@extends('layouts.app')

@section('title', 'Đánh Giá Của Tôi')

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
    .review-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        transition: all 0.3s;
        overflow: hidden;
        background: white;
    }
    .review-card:hover {
        border-color: #c41e3a;
        box-shadow: 0 4px 15px rgba(196, 30, 58, 0.15);
        transform: translateY(-2px);
    }
    .review-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }
    .review-body {
        padding: 20px;
    }
    .movie-thumb {
        width: 80px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .star-rating {
        color: #ffc107;
        font-size: 18px;
    }
    .star-rating .bi-star-fill {
        margin-right: 2px;
    }
</style>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('phim.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile') }}">Hồ Sơ</a></li>
            <li class="breadcrumb-item active">Đánh giá của tôi</li>
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
                        <a href="{{ route('profile.tickets') }}" class="profile-menu-link">
                            <i class="bi bi-ticket-perforated"></i>
                            <span>Vé đã đặt</span>
                        </a>
                    </li>
                    <li class="profile-menu-item">
                        <a href="{{ route('profile.reviews') }}" class="profile-menu-link active">
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
                        <i class="bi bi-star-fill" style="color: #c41e3a;"></i> Đánh giá của tôi
                    </h2>

                    @if($reviews->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-star" style="font-size: 80px; color: #dee2e6;"></i>
                            <h4 class="mt-3 text-muted">Chưa có đánh giá nào</h4>
                            <p class="text-muted">Bạn chưa đánh giá phim nào. Hãy xem phim và để lại đánh giá của bạn!</p>
                            <a href="{{ route('phim.index') }}" class="btn btn-primary mt-3" style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); border: none;">
                                <i class="bi bi-film"></i> Xem phim
                            </a>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach($reviews as $review)
                                <div class="col-12">
                                    <div class="review-card">
                                        <div class="review-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="star-rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->diem)
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="ms-2 text-dark fw-semibold">{{ $review->diem }}/5</span>
                                                </div>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3"></i>
                                                    {{ \Carbon\Carbon::parse($review->ngay_tao)->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="review-body">
                                            <div class="d-flex gap-3">
                                <!-- Movie Thumbnail -->
                                <div class="flex-shrink-0">
                                    @if($review->phim->hinh_anh)
                                        <img src="{{ asset('asset/' . $review->phim->hinh_anh) }}" 
                                             alt="{{ $review->phim->ten_phim }}" 
                                             class="movie-thumb">
                                    @else
                                        <div class="movie-thumb bg-secondary d-flex align-items-center justify-content-center text-white">
                                            <i class="bi bi-film fs-3"></i>
                                        </div>
                                    @endif
                                </div>                                                <!-- Review Content -->
                                                <div class="flex-grow-1">
                                                    <h5 class="fw-bold mb-2">
                                                        <a href="{{ route('phim.show', $review->phim->phim_id) }}" 
                                                           class="text-dark text-decoration-none hover-primary">
                                                            {{ $review->phim->ten_phim }}
                                                        </a>
                                                    </h5>
                                                    
                                                    @if($review->binh_luan)
                                                        <div class="mt-3">
                                                            <p class="text-secondary mb-0" style="line-height: 1.6;">
                                                                <i class="bi bi-chat-quote" style="color: #c41e3a;"></i>
                                                                "{{ $review->binh_luan }}"
                                                            </p>
                                                        </div>
                                                    @else
                                                        <p class="text-muted fst-italic mb-0">Không có bình luận</p>
                                                    @endif

                                                    {{-- <div class="mt-3">
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="bi bi-tag"></i> 
                                                            Mã đánh giá: {{ $review->danh_gia_id }}
                                                        </span>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-primary:hover {
        color: #c41e3a !important;
    }
</style>
@endsection
