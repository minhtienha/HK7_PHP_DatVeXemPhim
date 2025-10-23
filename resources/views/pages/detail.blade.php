@extends('layouts.app')

@section('title', 'Chi tiết Phim - ' . $phim->ten_phim)

@section('content')
    <!-- Hero Section -->
    <div class="container py-5">
        <div class="row align-items-center bg-white rounded shadow-sm p-4">
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <img src="{{ asset('asset/' . $phim->hinh_anh) }}" 
                     alt="{{ $phim->ten_phim }}" 
                     class="img-fluid rounded">
            </div>
            <div class="col-md-8">
                <h1 class="fw-bold mb-3">{{ $phim->ten_phim }}</h1>
                <p class="text-muted mb-3">{{ Str::limit($phim->mo_ta, 200) }}</p>
                <p><strong>Thể loại:</strong>
                    @foreach ($phim->theLoai as $theLoai)
                        {{ $theLoai->ten_the_loai }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </p>
                <p><strong>Thời lượng:</strong> {{ $phim->thoi_luong }}</p>
                <p><strong>Ngày khởi chiếu: </strong>{{date('d-m-Y', strtotime($phim->ngay_cong_chieu))}}</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('phim.index') }}" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <ul class="nav nav-tabs w-100" id="phimTab" role="tablist">
            <li class="nav-item w-50" role="presentation">
                <button class="nav-link active w-100 text-center" id="showtime-tab" 
                        data-bs-toggle="tab" data-bs-target="#showtime" 
                        type="button" role="tab">
                    Suất chiếu
                </button>
            </li>
            <li class="nav-item w-50" role="presentation">
                <button class="nav-link w-100 text-center" id="review-tab" 
                        data-bs-toggle="tab" data-bs-target="#review" 
                        type="button" role="tab">
                    Đánh giá
                </button>
            </li>
        </ul>

        <div class="tab-content bg-white rounded-bottom shadow-sm p-4" id="phimTabContent">
            <!-- Tab Suất chiếu -->
            <div class="tab-pane fade show active" id="showtime" role="tabpanel">
                <h4 class="text-primary mb-3">Lịch chiếu</h4>
                @php
                    $groupedSuatChieu = $phim->suatChieu->groupBy(function($suat) {
                        return date('d-m-Y', strtotime($suat->ngay_chieu));
                    });
                @endphp
                @forelse($groupedSuatChieu as $ngay => $suats)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ date('d-m-Y', strtotime($ngay)) }}</h5>
                            <div class="row">
                                @foreach($suats as $suat)
                                    <div class="col-md-3 mb-2">
                                        <div class="border rounded p-2 text-center">
                                            <p class="mb-1"><strong>{{ $suat->gio_bat_dau }}</strong></p>
                                            <a href="{{ route('pages.booking', ['suat_chieu_id' => $suat->suat_chieu_id]) }}" class="btn btn-sm btn-primary">Đặt vé</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-secondary">Hiện chưa có suất chiếu nào cho phim này.</div>
                @endforelse
            </div>

            <!-- Tab Đánh giá -->
            <div class="tab-pane fade" id="review" role="tabpanel">
                <h4 class="text-primary mb-3">Đánh giá từ khán giả</h4>
                <form action="{{ route('danhgiaphim.create', $phim->phim_id) }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="phim_id" value="{{ $phim->phim_id }}">
                    <div class="mb-3">
                        <label for="diem" class="form-label">Đánh giá của bạn:</label>
                        <select name="diem" id="diem" class="form-select w-auto" required>
                            <option value="5">5 - Xuất sắc</option>
                            <option value="4">4 - Rất tốt</option>
                            <option value="3">3 - Tốt</option>
                            <option value="2">2 - Trung bình</option>
                            <option value="1">1 - Kém</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="binh_luan" class="form-label">Bình luận:</label>
                        <textarea name="binh_luan" id="binh_luan" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </form>
                @forelse($phim->danhGia as $danhgia)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">{{ $danhgia->nguoiDung->ho_ten  }}</h6>
                                <small class="text-muted">Vào lúc: {{ date('H-m :d-m-Y', strtotime($danhgia->ngay_tao)) }}</small>
                            </div>
                            <div class="mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $danhgia->diem ? 'text-warning' : 'text-secondary' }}">★</span>
                                @endfor
                                <span class="ms-2 text-muted">{{ $danhgia->diem }}/5</span>
                            </div>
                            <p class="mb-0">{{ $danhgia->binh_luan }}</p>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-secondary">Chưa có đánh giá nào cho phim này.</div>
                @endforelse
                
            </div>
        </div>
    </div>

@endsection