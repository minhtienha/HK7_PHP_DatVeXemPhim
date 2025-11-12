@extends('admin.layout')

@section('title', 'Chỉnh sửa suất chiếu')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit text-warning"></i> Chỉnh sửa suất chiếu</h1>
        <a href="{{ route('admin.suatchieu.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.suatchieu.update', $suatChieu->suat_chieu_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phim <span class="text-danger">*</span></label>
                        <select name="phim_id" class="form-select" required>
                            <option value="">-- Chọn phim --</option>
                            @foreach($phims as $phim)
                                <option value="{{ $phim->phim_id }}" {{ old('phim_id', $suatChieu->phim_id) == $phim->phim_id ? 'selected' : '' }}>
                                    {{ $phim->ten_phim }} ({{ $phim->thoi_luong }} phút)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phòng chiếu <span class="text-danger">*</span></label>
                        <select name="phong_id" class="form-select" required>
                            <option value="">-- Chọn phòng --</option>
                            @foreach($phongChieus as $phong)
                                <option value="{{ $phong->phong_id }}" {{ old('phong_id', $suatChieu->phong_id) == $phong->phong_id ? 'selected' : '' }}>
                                    {{ $phong->ten_phong }} ({{ $phong->suc_chua }} chỗ)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ngày chiếu <span class="text-danger">*</span></label>
                        <input type="date" name="ngay_chieu" class="form-control" value="{{ old('ngay_chieu', $suatChieu->ngay_chieu) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giờ bắt đầu <span class="text-danger">*</span></label>
                        <input type="time" name="gio_bat_dau" class="form-control" value="{{ old('gio_bat_dau', substr($suatChieu->gio_bat_dau, 0, 5)) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giờ kết thúc <span class="text-danger">*</span></label>
                        <input type="time" name="gio_ket_thuc" class="form-control" value="{{ old('gio_ket_thuc', substr($suatChieu->gio_ket_thuc, 0, 5)) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá vé (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="gia_ve" class="form-control" value="{{ old('gia_ve', $suatChieu->gia_ve) }}" required min="0" step="1000">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select name="trang_thai" class="form-select" required>
                            <option value="con_cho" {{ old('trang_thai', $suatChieu->trang_thai) == 'con_cho' ? 'selected' : '' }}>Còn chỗ</option>
                            <option value="het_cho" {{ old('trang_thai', $suatChieu->trang_thai) == 'het_cho' ? 'selected' : '' }}>Hết chỗ</option>
                            <option value="huy" {{ old('trang_thai', $suatChieu->trang_thai) == 'huy' ? 'selected' : '' }}>Hủy</option>
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-save"></i> Cập nhật suất chiếu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
