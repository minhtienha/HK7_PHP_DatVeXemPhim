@extends('layouts.app')

@section('title', 'Đăng Nhập')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <!-- Login Card -->
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <!-- Card Header Gradient -->
                <div style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); padding: 30px; text-align: center;">
                    <h2 class="fw-bold text-white mb-2" style="font-size: 28px;">
                        Đăng Nhập
                    </h2>
                    {{-- <p class="text-white mb-0" style="opacity: 0.9;">Đăng nhập để đặt vé và xem lịch sử đặt vé</p> --}}
                </div>
                <div class="card-body p-5" style="background: #23272b; color: #fff;">
                    <!-- Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i>
                            <ul class="mb-0 ms-2">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-white">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-envelope" style="color: #c41e3a;"></i>
                                </span>
                                <input type="email" id="email" name="email" class="form-control border-0 @error('email') is-invalid @enderror" 
                                       placeholder="Nhập email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="mat_khau" class="form-label fw-bold text-white">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-lock" style="color: #c41e3a;"></i>
                                </span>
                                <input type="password" id="mat_khau" name="mat_khau" class="form-control border-0 @error('mat_khau') is-invalid @enderror" 
                                       placeholder="••••••••" required>
                            </div>
                            @error('mat_khau')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label text-white" for="remember">
                                    Lưu đăng nhập
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none" style="color: #f3a633; font-weight: 500;">
                                Quên mật khẩu?
                            </a>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold py-2" 
                                style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); color: white; border: none;">
                            <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập
                        </button>
                    </form>

                    <hr class="my-4" style="border-color: #444;">

                    <!-- Register Link -->
                    <p class="text-center text-light mb-0">
                        Chưa có tài khoản? 
                        <a href="{{ route('register') }}" style="color: #f3a633; font-weight: 600; text-decoration: none;">
                            Đăng ký ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection