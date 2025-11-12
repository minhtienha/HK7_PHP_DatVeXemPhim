@extends('admin.layout')

@section('title', 'Thêm phòng chiếu')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle text-primary"></i> Thêm phòng chiếu</h1>
        <a href="{{ route('admin.phongchieu.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.phongchieu.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Tên phòng <span class="text-danger">*</span></label>
                    <input type="text" name="ten_phong" class="form-control" value="{{ old('ten_phong') }}" required placeholder="Ví dụ: Phòng 1, Phòng VIP...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Sức chứa <span class="text-danger">*</span></label>
                    <input type="number" name="suc_chua" class="form-control" value="{{ old('suc_chua') }}" required min="1" max="500">
                    <small class="text-muted">Số lượng người tối đa</small>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Lưu phòng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
