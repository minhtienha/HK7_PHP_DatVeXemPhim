<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1b1b18] min-h-screen flex items-center justify-center">
    <div class="bg-[#1e1e1e] p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-white mb-2">Đăng ký tài khoản</h2>
        <p class="text-center text-gray-400 mb-6">Tạo tài khoản để trải nghiệm đặt vé xem phim nhanh chóng</p>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-600 text-white text-center">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded bg-red-600 text-white text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="mb-4 p-3 rounded bg-red-600 text-white">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="ho_ten" class="block text-sm font-medium text-gray-300 mb-1">Họ và tên</label>
                    <input type="text" id="ho_ten" name="ho_ten" value="{{ old('ho_ten') }}" required
                        class="w-full px-4 py-2 bg-[#2d2d2d] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Nguyễn Văn A">
                    @error('ho_ten')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="so_dien_thoai" class="block text-sm font-medium text-gray-300 mb-1">Số điện thoại</label>
                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" value="{{ old('so_dien_thoai') }}" required
                        pattern="[\d+]{9,15}"
                        class="w-full px-4 py-2 bg-[#2d2d2d] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="0987654321">
                    @error('so_dien_thoai')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 bg-[#2d2d2d] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="your@email.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="mat_khau" class="block text-sm font-medium text-gray-300 mb-1">Mật khẩu</label>
                <input type="password" id="mat_khau" name="mat_khau" required minlength="6"
                    class="w-full px-4 py-2 bg-[#2d2d2d] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="********">
                @error('mat_khau')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-400 mt-1">Mật khẩu tối thiểu 6 ký tự.</p>
            </div>

            <div class="flex items-center mb-6">
                <input type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}
                    class="w-4 h-4 text-red-600 bg-[#2d2d2d] border-gray-600 rounded">
                <label for="terms" class="ml-2 text-sm text-gray-400">Tôi đồng ý với điều khoản và dịch vụ</label>
                @error('terms')
                    <p class="mt-1 text-sm text-red-400 ml-6">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                Đăng ký
            </button>
        </form>

        <p class="text-center text-sm text-gray-400 mt-4">
            Đã có tài khoản? <a href="{{ route('login') }}" class="text-red-500 hover:underline">Đăng nhập ngay</a>
        </p>
    </div>
</body>
</html>
