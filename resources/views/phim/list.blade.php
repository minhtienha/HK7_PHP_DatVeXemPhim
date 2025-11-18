@extends('layouts.app')

@section('title', 'Danh Sách Phim - MovieTicket')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('phim.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Danh Sách Phim</li>
        </ol>
    </nav>

    {{-- <h1 class="fw-bold mb-4"><i class="bi bi-film"></i> Danh Sách Phim</h1> --}}

    <!-- Search and Filter Card -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('phim.list') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label fw-bold">Tìm kiếm</label>
                    <input type="text" id="search" name="search" class="form-control" 
                           placeholder="Tìm tên phim..." value="{{ request('search') }}">
                </div>
                <div class="col-md-5">
                    <label for="the_loai" class="form-label fw-bold">Thể loại</label>
                    <select id="the_loai" name="the_loai" class="form-select">
                        <option value="">-- Tất cả thể loại --</option>
                        @foreach ($theLoais as $theLoai)
                            <option value="{{ $theLoai->the_loai_id }}" 
                                    {{ request('the_loai') == $theLoai->the_loai_id ? 'selected' : '' }}>
                                {{ $theLoai->ten_the_loai }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn w-100 fw-bold" 
                            style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); color: white; border: none;">
                        <i class="bi bi-search"></i> Tìm
                    </button>
                </div>
                @if(request('search') || request('the_loai'))
                    <div class="col-md-12">
                        <a href="{{ route('phim.list') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Xóa Bộ Lọc
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Phim Đang Chiếu -->
    <h2 class="mb-4 fw-bold">Phim Đang Chiếu</h2>
    <div id="phims-chieu" class="row g-4 mb-5">
        @include('phim.partials.movie-grid', ['phims' => $phimsChieuGan])
    </div>
    @if($phimsChieuGan->hasPages())
        <div id="pagination-chieu" class="d-flex justify-content-center mb-5">
            {{ $phimsChieuGan->links() }}
        </div>
    @endif

    <!-- Phim Sắp Chiếu -->
    <h2 class="mb-4 fw-bold">Phim Sắp Chiếu</h2>
    <div id="phims-sap" class="row g-4 mb-5">
        @include('phim.partials.movie-grid', ['phims' => $phimsSapChieu])
    </div>
    @if($phimsSapChieu->hasPages())
        <div id="pagination-sap" class="d-flex justify-content-center mb-5">
            {{ $phimsSapChieu->links() }}
        </div>
    @endif
</div>

<style>
    /* Xóa hover effect */
</style>
@endsection
