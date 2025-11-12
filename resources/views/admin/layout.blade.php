<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - MovieBooking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(220, 38, 38, 0.2);
            color: #dc2626;
        }
        .sidebar .nav-link i {
            width: 25px;
            margin-right: 10px;
        }
        .main-content {
            padding: 30px;
        }
        .stat-card {
            border-radius: 15px;
            padding: 25px;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .stat-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }
        .stat-card p {
            margin: 0;
            opacity: 0.9;
        }
        .bg-primary-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .bg-success-custom { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .bg-warning-custom { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .bg-info-custom { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .bg-danger-custom { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .bg-secondary-custom { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 col-lg-2 d-md-block sidebar p-3">
                <div class="text-center mb-4">
                    <h3 class="text-white fw-bold">🎬 Admin</h3>
                    <p class="text-white-50 small">{{ auth()->user()->ho_ten }}</p>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.phim.*') ? 'active' : '' }}" href="{{ route('admin.phim.index') }}">
                            <i class="fas fa-film"></i> Quản lý Phim
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.theloai.*') ? 'active' : '' }}" href="{{ route('admin.theloai.index') }}">
                            <i class="fas fa-tags"></i> Quản lý Thể loại
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.phongchieu.*') ? 'active' : '' }}" href="{{ route('admin.phongchieu.index') }}">
                            <i class="fas fa-door-open"></i> Quản lý Phòng chiếu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.ghengoi.*') ? 'active' : '' }}" href="{{ route('admin.ghengoi.index') }}">
                            <i class="fas fa-couch"></i> Quản lý Ghế
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.suatchieu.*') ? 'active' : '' }}" href="{{ route('admin.suatchieu.index') }}">
                            <i class="fas fa-clock"></i> Quản lý Suất chiếu
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link" href="{{ route('phim.index') }}">
                            <i class="fas fa-arrow-left"></i> Về trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-start w-100" style="text-decoration: none;">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 col-lg-10 ms-sm-auto main-content">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
