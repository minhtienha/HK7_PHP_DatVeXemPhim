@extends('admin.layout')

@section('title', 'Quản lý Thể loại')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-tags text-primary"></i> Quản lý Thể loại</h1>
        <a href="{{ route('admin.theloai.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm thể loại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 100px">ID</th>
                            <th>Tên thể loại</th>
                            <th style="width: 200px">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($theLoais as $tl)
                            <tr>
                                <td><code>{{ $tl->the_loai_id }}</code></td>
                                <td><strong>{{ $tl->ten_the_loai }}</strong></td>
                                <td>
                                    <a href="{{ route('admin.theloai.edit', $tl->the_loai_id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.theloai.destroy', $tl->the_loai_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    Chưa có thể loại nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $theLoais->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
