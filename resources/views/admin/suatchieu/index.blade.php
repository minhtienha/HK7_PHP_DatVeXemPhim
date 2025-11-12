@extends('admin.layout')

@section('title', 'Quản lý Suất chiếu')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-clock text-primary"></i> Quản lý Suất chiếu</h1>
        <a href="{{ route('admin.suatchieu.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm suất chiếu
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Phim</th>
                            <th>Phòng</th>
                            <th>Ngày chiếu</th>
                            <th>Giờ</th>
                            <th>Giá vé</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suatChieus as $sc)
                            <tr>
                                <td><code>{{ $sc->suat_chieu_id }}</code></td>
                                <td><strong>{{ $sc->phim->ten_phim ?? 'N/A' }}</strong></td>
                                <td>{{ $sc->phongChieu->ten_phong ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($sc->ngay_chieu)->format('d/m/Y') }}</td>
                                <td>{{ substr($sc->gio_bat_dau, 0, 5) }} - {{ substr($sc->gio_ket_thuc, 0, 5) }}</td>
                                <td><strong>{{ number_format($sc->gia_ve, 0, ',', '.') }}đ</strong></td>
                                <td>
                                    @if($sc->trang_thai == 'con_cho')
                                        <span class="badge bg-success">Còn chỗ</span>
                                    @elseif($sc->trang_thai == 'het_cho')
                                        <span class="badge bg-danger">Hết chỗ</span>
                                    @else
                                        <span class="badge bg-secondary">Hủy</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.suatchieu.edit', $sc->suat_chieu_id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.suatchieu.destroy', $sc->suat_chieu_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa suất chiếu này?')">
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
                                    Chưa có suất chiếu nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $suatChieus->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
