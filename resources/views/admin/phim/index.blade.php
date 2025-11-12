@extends('admin.layout')

@section('title', 'Quản lý Phim')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-film text-primary"></i> Quản lý Phim</h1>
        <a href="{{ route('admin.phim.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm phim mới
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên phim</th>
                            <th>Đạo diễn</th>
                            <th>Thời lượng</th>
                            <th>Ngày công chiếu</th>
                            <th>Trạng thái</th>
                            <th>Thể loại</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($phims as $phim)
                            <tr>
                                <td><code>{{ $phim->phim_id }}</code></td>
                                <td><strong>{{ $phim->ten_phim }}</strong></td>
                                <td>{{ $phim->dao_dien ?? 'N/A' }}</td>
                                <td>{{ $phim->thoi_luong }} phút</td>
                                <td>{{ $phim->ngay_cong_chieu }}</td>
                                <td>
                                    @if($phim->trang_thai == 'dang_chieu')
                                        <span class="badge bg-success">Đang chiếu</span>
                                    @elseif($phim->trang_thai == 'sap_chieu')
                                        <span class="badge bg-warning">Sắp chiếu</span>
                                    @else
                                        <span class="badge bg-secondary">Ngừng chiếu</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($phim->theLoais as $tl)
                                        <span class="badge bg-info">{{ $tl->ten_the_loai }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.phim.edit', $phim->phim_id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.phim.destroy', $phim->phim_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa phim này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    Chưa có phim nào. Hãy thêm phim mới!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $phims->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
