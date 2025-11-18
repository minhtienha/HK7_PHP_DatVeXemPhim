@extends('layouts.app')

@section('title', 'Chi tiết Phim - ' . $phim->ten_phim)

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('phim.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($phim->ten_phim, 50) }}</li>
        </ol>
    </nav>

    <!-- Movie Info Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <img src="{{ asset('asset/' . $phim->hinh_anh) }}" alt="{{ $phim->ten_phim }}" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                </div>
                <div class="col-md-8">
                    <h1 class="fw-bold mb-3 text-dark">{{ $phim->ten_phim }}</h1>
                    <div class="mb-3">
                        @php
                            $soDanhGia = $phim->danhGia->count();
                            $diemTrungBinh = $soDanhGia > 0 ? round($phim->danhGia->avg('diem'), 1) : null;
                        @endphp
                        @if($soDanhGia > 0)
                            <span class="badge bg-warning text-dark me-2">★ {{ $diemTrungBinh }}/5</span>
                            <small class="text-muted">({{ $soDanhGia }} đánh giá)</small>
                        @else
                            <span class="badge bg-secondary">Chưa có đánh giá</span>
                        @endif
                    </div>
                    <p class="text-muted mb-3">{{ $phim->mo_ta }}</p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Thể loại:</strong></p>
                            @foreach ($phim->theLoais as $theLoai)
                                <span class="badge bg-light text-dark">{{ $theLoai->ten_the_loai }}</span>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <p><strong>Thời lượng:</strong> {{ $phim->thoi_luong }} phút</p>
                            <p><strong>Ngày khởi chiếu:</strong> {{ date('d/m/Y', strtotime($phim->ngay_cong_chieu)) }}</p>
                        </div>
                    </div>
                    <a href="{{ route('phim.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="phimTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="showtime-tab" data-bs-toggle="tab" data-bs-target="#showtime" type="button" role="tab">
                <i class="bi bi-calendar-event"></i> Suất Chiếu
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab">
                <i class="bi bi-chat-left-text"></i> Đánh Giá
            </button>
        </li>
    </ul>

    <div class="tab-content" id="phimTabContent">
        <!-- Showtime Tab -->
        <div class="tab-pane fade show active" id="showtime" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4"><i class="bi bi-calendar2-event"></i> Chọn Suất Chiếu</h5>
                    @php
                        $groupedSuatChieu = $phim->suatChieu->groupBy(function($suat) {
                            return date('d-m-Y', strtotime($suat->ngay_chieu));
                        });
                    @endphp
                    @forelse($groupedSuatChieu as $ngay => $suats)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">
                                {{ date('l, d/m/Y', strtotime($ngay)) }}
                            </h6>
                            <div class="row g-2">
                                @foreach($suats as $suat)
                                    <div class="col-auto">
                                        <a href="{{ route('pages.booking', ['suat_chieu_id' => $suat->suat_chieu_id]) }}" 
                                           class="btn btn-outline-primary fw-bold">
                                            {{ $suat->gio_bat_dau }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Hiện chưa có suất chiếu nào cho phim này.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Review Tab -->
        <div class="tab-pane fade" id="review" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4"><i class="bi bi-chat-left-text"></i> Đánh Giá & Bình Luận</h5>

                    <!-- Add Review Form -->
                    @auth
                        <form action="{{ route('danhgiaphim.create', $phim->phim_id) }}" method="POST" class="mb-5 p-3 bg-light rounded">
                            @csrf
                            <input type="hidden" name="phim_id" value="{{ $phim->phim_id }}">
                            <h6 class="fw-bold mb-3">Gửi Đánh Giá Của Bạn</h6>
                            <div class="mb-3">
                                <label for="diem" class="form-label">Đánh giá:</label>
                                <select name="diem" id="diem" class="form-select w-auto" required>
                                    <option value="5">⭐⭐⭐⭐⭐ - Xuất sắc</option>
                                    <option value="4">⭐⭐⭐⭐ - Rất tốt</option>
                                    <option value="3">⭐⭐⭐ - Tốt</option>
                                    <option value="2">⭐⭐ - Trung bình</option>
                                    <option value="1">⭐ - Kém</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="binh_luan" class="form-label">Bình luận:</label>
                                <textarea name="binh_luan" id="binh_luan" class="form-control" rows="3" placeholder="Chia sẻ ý kiến của bạn..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Gửi Đánh Giá
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning mb-4">
                            <i class="bi bi-exclamation-triangle"></i> 
                            <a href="{{ route('login') }}">Đăng nhập</a> để gửi đánh giá của bạn
                        </div>
                    @endauth

                    <!-- Reviews List -->
                    <hr>
                    <h6 class="fw-bold mb-3">Đánh giá từ cộng đồng</h6>
                    @forelse($phim->danhGia as $danhgia)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $danhgia->nguoiDung->ho_ten }}</h6>
                                        <small class="text-muted">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="text-warning">{{ $i <= $danhgia->diem ? '★' : '☆' }}</span>
                                            @endfor
                                            {{ $danhgia->diem }}/5
                                        </small>
                                    </div>
                                    <small class="text-muted">{{ $danhgia->ngay_tao->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{{ $danhgia->binh_luan }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Chưa có đánh giá nào cho phim này.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection