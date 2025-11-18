@extends('layouts.app')

@section('title', 'Trang Chủ - MovieTicket')

@section('content')
<div class="container">

    <!-- Phim Đang Chiếu -->
    <h2 class="mb-4 fw-bold">Phim Đang Chiếu</h2>
    <div class="row g-4 mb-5">
        @forelse ($phimsChieuGan as $phim)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="{{ route('phim.show', $phim->phim_id) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm hover-shadow transition" style="transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;">
                        <div style="position: relative; overflow: hidden; height: 300px;">
                            <img src="{{ asset('asset/' . $phim->hinh_anh) }}" alt="{{ $phim->ten_phim }}" 
                                 class="card-img-top h-100" style="object-fit: cover;">
                            @php
                                $soDanhGia = $phim->danhGia->count();
                                $diemTrungBinh = $soDanhGia > 0 ? round($phim->danhGia->avg('diem'), 1) : null;
                            @endphp
                            <span class="badge bg-warning text-dark position-absolute top-2 end-2">
                                @if($soDanhGia > 0)
                                    ★ {{ $diemTrungBinh }}
                                @else
                                    Mới
                                @endif
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ Str::limit($phim->ten_phim, 25) }}</h5>
                            <p class="card-text text-muted small mb-2">
                                @foreach ($phim->theLoais as $theLoai)
                                    <span class="badge bg-light text-dark">{{ $theLoai->ten_the_loai }}</span>
                                @endforeach
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Thời lượng: {{ $phim->thoi_luong }} phút</small>
                                <small class="text-muted">Ngày: {{ date('d/m/Y', strtotime($phim->ngay_cong_chieu)) }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> Không có phim đang chiếu
                </div>
            </div>
        @endforelse
    </div>

    <!-- Phim Sắp Chiếu -->
    <h2 class="mb-4 fw-bold">Phim Sắp Chiếu</h2>
    <div class="row g-4 mb-5">
        @forelse ($phimsSapChieu as $phim)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="{{ route('phim.show', $phim->phim_id) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm hover-shadow transition" style="transition: transform 0.3s, box-shadow 0.3s; cursor: pointer; opacity: 0.85;">
                        <div style="position: relative; overflow: hidden; height: 300px;">
                            <img src="{{ asset('asset/' . $phim->hinh_anh) }}" alt="{{ $phim->ten_phim }}" 
                                 class="card-img-top h-100" style="object-fit: cover;">
                            <span class="badge bg-danger position-absolute top-2 end-2">
                                Sắp Chiếu
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ Str::limit($phim->ten_phim, 25) }}</h5>
                            <p class="card-text text-muted small mb-2">
                                @foreach ($phim->theLoais as $theLoai)
                                    <span class="badge bg-light text-dark">{{ $theLoai->ten_the_loai }}</span>
                                @endforeach
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Thời lượng: {{ $phim->thoi_luong }} phút</small>
                                <small class="text-muted">Ngày: {{ date('d/m/Y', strtotime($phim->ngay_cong_chieu)) }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> Không có phim sắp chiếu
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection