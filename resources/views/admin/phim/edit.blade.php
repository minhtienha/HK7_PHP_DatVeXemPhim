@extends('admin.layout')

@section('title', 'Chỉnh sửa phim')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit text-warning"></i> Chỉnh sửa: {{ $phim->ten_phim }}</h1>
        <a href="{{ route('admin.phim.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.phim.update', $phim->phim_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên phim <span class="text-danger">*</span></label>
                        <input type="text" name="ten_phim" class="form-control" value="{{ old('ten_phim', $phim->ten_phim) }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Thời lượng (phút)</label>
                        <input type="number" name="thoi_luong" class="form-control" value="{{ old('thoi_luong', $phim->thoi_luong) }}" min="1">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select name="trang_thai" class="form-select" required>
                            <option value="dang_chieu" {{ old('trang_thai', $phim->trang_thai) == 'dang_chieu' ? 'selected' : '' }}>Đang chiếu</option>
                            <option value="sap_chieu" {{ old('trang_thai', $phim->trang_thai) == 'sap_chieu' ? 'selected' : '' }}>Sắp chiếu</option>
                            <option value="ngung_chieu" {{ old('trang_thai', $phim->trang_thai) == 'ngung_chieu' ? 'selected' : '' }}>Ngừng chiếu</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Đạo diễn</label>
                        <input type="text" name="dao_dien" class="form-control" value="{{ old('dao_dien', $phim->dao_dien) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Diễn viên</label>
                        <input type="text" name="dien_vien" class="form-control" value="{{ old('dien_vien', $phim->dien_vien) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày công chiếu</label>
                        <input type="date" name="ngay_cong_chieu" class="form-control" value="{{ old('ngay_cong_chieu', $phim->ngay_cong_chieu) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hình ảnh phim</label>
                        @if($phim->hinh_anh)
                            <div class="mb-2">
                                <img src="{{ asset('assets/' . $phim->hinh_anh) }}" alt="{{ $phim->ten_phim }}" style="max-width: 150px; max-height: 200px; object-fit: cover;" class="img-thumbnail">
                                <div class="text-muted small mt-1">Ảnh hiện tại: {{ $phim->hinh_anh }}</div>
                            </div>
                        @endif
                        <input type="file" name="hinh_anh" class="form-control" accept="image/*">
                        <small class="text-muted">Chọn ảnh mới để thay đổi (để trống nếu không đổi). Tối đa 2MB</small>
                        @error('hinh_anh')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thể loại</label>
                    <div class="row">
                        @foreach($theLoais as $tl)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="the_loai[]" value="{{ $tl->the_loai_id }}" 
                                        id="tl{{ $tl->the_loai_id }}" 
                                        {{ in_array($tl->the_loai_id, old('the_loai', $selectedTheLoais)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tl{{ $tl->the_loai_id }}">
                                        {{ $tl->ten_the_loai }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="mo_ta" class="form-control" rows="5">{{ old('mo_ta', $phim->mo_ta) }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-save"></i> Cập nhật phim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview ảnh mới khi chọn file
document.querySelector('input[name="hinh_anh"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            // Tìm hoặc tạo preview
            let preview = document.getElementById('new-image-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'new-image-preview';
                preview.className = 'mt-2';
                e.target.parentNode.appendChild(preview);
            }
            preview.innerHTML = `<div class="alert alert-info">Ảnh mới sẽ thay thế ảnh cũ:</div>
                                 <img src="${event.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 250px; object-fit: cover;">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
