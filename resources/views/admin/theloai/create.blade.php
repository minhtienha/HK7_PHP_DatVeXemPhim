@extends('admin.layout')

@section('title', 'Thêm thể loại')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle text-primary"></i> Thêm thể loại mới</h1>
        <a href="{{ route('admin.theloai.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.theloai.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Tên thể loại <span class="text-danger">*</span></label>
                    <input type="text" name="ten_the_loai" class="form-control" value="{{ old('ten_the_loai') }}" required placeholder="Ví dụ: Hành động, Kinh dị...">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
