@extends('layouts.app')

@section('title', 'Đăng Ký Tài Khoản')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Register Card -->
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <!-- Card Header Gradient -->
                <div style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); padding: 30px; text-align: center;">
                    <h2 class="fw-bold text-white mb-2" style="font-size: 28px;">
                         Đăng Ký Tài Khoản
                    </h2>
                    {{-- <p class="text-white mb-0" style="opacity: 0.9;">Tạo tài khoản để đặt vé xem phim dễ dàng hơn</p> --}}
                </div>
                <div class="card-body p-5" style="background: #23272b; color: #fff;">
                    <!-- Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
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

                    <!-- Register Form -->
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <!-- Name & Phone Row -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ho_ten" class="form-label fw-bold text-white">Họ và tên</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-person" style="color: #c41e3a;"></i>
                                    </span>
                                    <input type="text" id="ho_ten" name="ho_ten" class="form-control border-0 @error('ho_ten') is-invalid @enderror" 
                                           placeholder="Nguyễn Văn A" value="{{ old('ho_ten') }}" required>
                                </div>
                                @error('ho_ten')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="so_dien_thoai" class="form-label fw-bold text-white">Số điện thoại</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-telephone" style="color: #c41e3a;"></i>
                                    </span>
                                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="form-control border-0 @error('so_dien_thoai') is-invalid @enderror" 
                                           placeholder="0987654321" value="{{ old('so_dien_thoai') }}" required>
                                </div>
                                @error('so_dien_thoai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <!-- Email -->
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
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="mat_khau" class="form-label fw-bold text-white">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-lock" style="color: #c41e3a;"></i>
                                </span>
                                <input type="password" id="mat_khau" name="mat_khau" class="form-control border-0 @error('mat_khau') is-invalid @enderror" 
                                       placeholder="••••••••" minlength="6" required>
                            </div>
                            <small class="text-light d-block mt-1">Mật khẩu tối thiểu 6 ký tự</small>
                            @error('mat_khau')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Terms -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                            <label class="form-check-label text-white" for="terms">
                                Tôi đồng ý với <a href="#" style="color: #f3a633; text-decoration: none;">điều khoản và dịch vụ</a>
                            </label>
                            @error('terms')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn w-100 fw-bold py-2" 
                                style="background: linear-gradient(135deg, #c41e3a 0%, #a01630 100%); color: white; border: none;">
                            <i class="bi bi-person-plus"></i> Đăng Ký
                        </button>
                    </form>
                    <hr class="my-4" style="border-color: #444;">
                    <!-- Login Link -->
                    <p class="text-center text-light mb-0">
                        Đã có tài khoản? 
                        <a href="{{ route('login') }}" style="color: #f3a633; font-weight: 600; text-decoration: none;">
                            Đăng nhập ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
