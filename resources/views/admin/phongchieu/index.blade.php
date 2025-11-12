@extends('admin.layout')

@section('title', 'Quản lý Phòng chiếu')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-door-open text-primary"></i> Quản lý Phòng chiếu</h1>
        <a href="{{ route('admin.phongchieu.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm phòng chiếu
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Phòng</th>
                            <th>Tên phòng</th>
                            <th>Sức chứa</th>
                            <th>Số ghế hiện có</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($phongChieus as $phong)
                            <tr>
                                <td><code>{{ $phong->phong_id }}</code></td>
                                <td><strong>{{ $phong->ten_phong }}</strong></td>
                                <td>{{ $phong->suc_chua }} người</td>
                                <td>
                                    <span class="badge bg-info">{{ $phong->ghe_ngoi_count }} ghế</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.ghengoi.index', ['phong_id' => $phong->phong_id]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-couch"></i> Ghế
                                    </a>
                                    <a href="{{ route('admin.phongchieu.edit', $phong->phong_id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.phongchieu.destroy', $phong->phong_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa phòng sẽ xóa tất cả ghế và suất chiếu liên quan!')">
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
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    Chưa có phòng chiếu nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $phongChieus->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
