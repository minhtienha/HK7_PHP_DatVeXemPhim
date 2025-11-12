@extends('admin.layout')

@section('title', 'Thêm ghế thủ công')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle text-primary"></i> Thêm ghế thủ công</h1>
        <a href="{{ route('admin.ghengoi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.ghengoi.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Phòng chiếu <span class="text-danger">*</span></label>
                    <select name="phong_id" class="form-select" required>
                        <option value="">-- Chọn phòng --</option>
                        @foreach($phongChieus as $phong)
                            <option value="{{ $phong->phong_id }}" {{ old('phong_id') == $phong->phong_id ? 'selected' : '' }}>
                                {{ $phong->ten_phong }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số ghế <span class="text-danger">*</span></label>
                    <input type="text" name="so_ghe" class="form-control" value="{{ old('so_ghe') }}" required placeholder="Ví dụ: A1, B5, C10...">
                    <small class="text-muted">Số ghế theo định dạng: Hàng + Số (A1, B2...)</small>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Lưu ghế
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
