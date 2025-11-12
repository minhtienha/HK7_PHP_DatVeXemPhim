@extends('admin.layout')

@section('title', 'Quản lý Ghế ngồi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-couch text-primary"></i> Quản lý Ghế ngồi</h1>
        <a href="{{ route('admin.ghengoi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm ghế thủ công
        </a>
    </div>

    <!-- Chọn phòng -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.ghengoi.index') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <label class="form-label">Chọn phòng chiếu</label>
                    <select name="phong_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Chọn phòng --</option>
                        @foreach($phongChieus as $phong)
                            <option value="{{ $phong->phong_id }}" {{ $phong_id == $phong->phong_id ? 'selected' : '' }}>
                                {{ $phong->ten_phong }} ({{ $phong->suc_chua }} chỗ)
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    @if($phong_id && $phongChieu)
        <!-- Tạo ghế tự động -->
        <div class="card shadow-sm mb-4 bg-light">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="fas fa-magic"></i> Tạo ghế tự động cho {{ $phongChieu->ten_phong }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.ghengoi.autogenerate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="phong_id" value="{{ $phong_id }}">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Số hàng (A, B, C...)</label>
                            <input type="number" name="so_hang" class="form-control" value="8" min="1" max="20" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Số ghế mỗi hàng</label>
                            <input type="number" name="so_ghe_moi_hang" class="form-control" value="10" min="1" max="30" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Tạo mới sẽ xóa tất cả ghế cũ. Tiếp tục?')">
                                <i class="fas fa-magic"></i> Tạo ghế tự động
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">Ví dụ: 8 hàng × 10 ghế = 80 ghế (A1-A10, B1-B10, ...)</small>
                </form>
            </div>
        </div>

        <!-- Danh sách ghế -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Danh sách ghế: <strong>{{ $phongChieu->ten_phong }}</strong> ({{ $ghes->count() }} ghế)</h5>
            </div>
            <div class="card-body">
                @if($ghes->count() > 0)
                    <!-- Hiển thị dạng sơ đồ ghế -->
                    <div style="max-width: 800px; margin: 0 auto;">
                        <div class="text-center mb-3">
                            <div class="bg-dark text-white p-2 rounded">
                                <i class="fas fa-tv"></i> MÀN HÌNH
                            </div>
                        </div>

                        @php
                            $ghesByHang = $ghes->groupBy(function($item) {
                                return substr($item->so_ghe, 0, 1); // Lấy ký tự đầu (A, B, C...)
                            });
                        @endphp

                        @foreach($ghesByHang as $hang => $ghesInHang)
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <span class="badge bg-secondary me-2" style="width: 30px;">{{ $hang }}</span>
                                @foreach($ghesInHang as $ghe)
                                    <div class="mx-1">
                                        <button type="button" class="btn btn-sm btn-success position-relative" style="width: 50px; height: 50px;" title="{{ $ghe->so_ghe }}">
                                            {{ $ghe->so_ghe }}
                                            <form action="{{ route('admin.ghengoi.destroy', $ghe->ghe_id) }}" method="POST" style="position: absolute; top: -5px; right: -5px;" onsubmit="return confirm('Xóa ghế này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-circle" style="width: 20px; height: 20px; padding: 0; font-size: 10px;">×</button>
                                            </form>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-couch fa-3x mb-3 d-block"></i>
                        <p>Chưa có ghế nào. Sử dụng tính năng tạo ghế tự động hoặc thêm thủ công.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Vui lòng chọn phòng chiếu để quản lý ghế.
        </div>
    @endif
</div>
@endsection
