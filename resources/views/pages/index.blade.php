@extends('layouts.app')

@section('title', 'Phim đang chiếu')

@push('styles')
<style>
  .card-img-wrapper {
    position: relative;
    overflow: hidden;
  }

  .card-img-wrapper img {
    width: 100%;
    height: auto;
    display: block;
  }

  .overlay-btn {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .card-img-wrapper:hover .overlay-btn {
    opacity: 1;
  }
</style>
@endpush

@section('content')
<div class="container py-5">
  <h2 class="text-center mb-4 text-dark">🎬 Phim đang chiếu</h2>
  <div class="row g-4">
    @foreach($phims as $phim)
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-img-wrapper">
          <img src="{{ asset('asset/' . $phim->hinh_anh) }}" alt="{{ $phim->ten_phim }}">
          <a href="{{ route('phim.show', $phim->phim_id) }}" class="btn btn-danger overlay-btn">Xem chi tiết</a>
        </div>
        <div class="card-body">
          <h5 class="card-title">{{ $phim->ten_phim }}</h5>
          <p class="card-text mb-1"><strong>Thể loại:</strong> {{ $phim->the_loai }}</p>
          <p class="card-text"><strong>Thời lượng:</strong> {{ $phim->thoi_luong }} phút</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
