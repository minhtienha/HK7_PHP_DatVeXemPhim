<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Đặt Vé Phim')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #c41e3a;
            --secondary-color: #f3a633;
        }
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #333 !important;
        }
        main {
            flex: 1;
        }
        p, h1, h2, h3, h4, h5, h6, span, a, button, input, select, textarea {
            color: inherit !important;
        }
        /* Input, textarea, select luôn nền trắng, chữ đen */
        input.form-control, textarea.form-control, select.form-control {
            color: #212529 !important;
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
        }
        input.form-control:focus, textarea.form-control:focus, select.form-control:focus {
            color: #212529 !important;
            background-color: #fff !important;
            border: 1.5px solid #c41e3a !important;
            box-shadow: 0 0 0 0.2rem rgba(196,30,58,0.10);
        }
        .navbar {
            background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: #fff !important;
        }
        .navbar-brand i {
            margin-right: 8px;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #f3a633 !important;
        }
        /* Fix Bootstrap nav-tabs text color */
        .nav-tabs .nav-link {
            color: #495057 !important;
        }
        .nav-tabs .nav-link.active {
            color: #c41e3a !important;
            border-bottom-color: #c41e3a !important;
        }
        .nav-tabs .nav-link:hover {
            color: #333 !important;
            border-color: #dee2e6 #dee2e6 #c41e3a !important;
        }
        footer {
            background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
            border-top: 3px solid #c41e3a;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #a01630;
            border-color: #a01630;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('phim.index') }}">
                <i class="bi bi-film"></i> T4-Ticket
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('phim.index') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('phim.list') }}">Phim</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">{{ Auth::user()->ho_ten }}</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="nav-link btn btn-link" style="color: rgba(255,255,255,0.8) !important;">Đăng xuất</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-info-circle"></i> T4-Ticket</h5>
                    <p class="small">Nền tảng đặt vé nhanh hơn Crush rep tin nhắn!</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-telephone"></i> Liên hệ</h5>
                    <p class="small">
                        📧 support@movieticket.com<br>
                        📞 1900-1234<br>
                        📍 TP. Hồ Chí Minh
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-share"></i> Kết nối</h5>
                    <div class="d-flex gap-2">
                        <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-secondary">
            <p class="text-center small mb-0">&copy; 2025 T4-Ticket. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
