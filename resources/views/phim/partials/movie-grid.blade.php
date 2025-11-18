@forelse ($phims as $phim)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <a href="{{ route('phim.show', $phim->phim_id) }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm">
                <div style="position: relative; overflow: hidden; height: 300px;">
                    <img src="{{ asset('asset/' . $phim->hinh_anh) }}" alt="{{ $phim->ten_phim }}" 
                         class="card-img-top h-100" style="object-fit: cover;">
                    @php
                        $soDanhGia = $phim->danhGia->count();
                        $diemTrungBinh = $soDanhGia > 0 ? round($phim->danhGia->avg('diem'), 1) : null;
                        $status = $phim->getStatus();
                    @endphp
                    <span class="badge bg-warning text-dark position-absolute top-2 end-2">
                        @if($soDanhGia > 0)
                            ★ {{ $diemTrungBinh }}
                        @else
                            Mới
                        @endif
                    </span>
                    <span class="badge position-absolute top-2 start-2 {{ $status == 'dang_chieu' ? 'bg-success' : ($status == 'sap_chieu' ? 'bg-primary' : 'bg-secondary') }}">
                        @if($status == 'dang_chieu')
                            Đang Chiếu
                        @elseif($status == 'sap_chieu')
                            Sắp Chiếu
                        @else
                            Đã Chiếu
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-dark fw-bold">{{ Str::limit($phim->ten_phim, 25) }}</h5>
                    <p class="card-text text-muted small mb-2">
                        @foreach ($phim->theLoais as $theLoai)
                            <span class="badge bg-light text-dark">{{ $theLoai->ten_the_loai }}</span>
                        @endforeach
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="bi bi-clock"></i> {{ $phim->thoi_luong }} phút</small>
                        <small class="text-muted"><i class="bi bi-calendar-event"></i> {{ date('d/m', strtotime($phim->ngay_cong_chieu)) }}</small>
                    </div>
                </div>
            </div>
        </a>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info text-center" role="alert">
            <i class="bi bi-info-circle"></i> Không có phim nào
        </div>
    </div>
@endforelse
