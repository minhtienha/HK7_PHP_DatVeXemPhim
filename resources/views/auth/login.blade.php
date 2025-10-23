<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .min-h-screen {
            min-height: 100vh;
        }
        .text-red-500 {
            color: #f53003;
        }
        .text-red-600 {
            color: #dc2626;
        }
        .bg-red-600 {
            background-color: #dc2626;
        }
    </style>
</head>
<body class="bg-[#1b1b18] text-white flex flex-col min-h-screen">

    <header class="bg-white shadow-lg">
    <nav class="container mx-auto p-4 flex items-center">
        <a href="/" class="text-black text-3xl font-bold">MovieBooking</a>
        
        <div class="flex-grow text-right space-x-12">
            <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Trang chủ</a>
            <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Phim</a>
            <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Rạp chiếu</a>
            <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Vé của tôi</a>
        </div>
        
        <a href="/login" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-full ml-12 text-lg">Đăng nhập</a>
    </nav>
    </header>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="bg-[#2d2d2d] p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-3xl font-bold text-center text-white mb-2">Đăng nhập</h2>
            <p class="text-center text-gray-400 mb-6">Chào mừng quay lại! Vui lòng đăng nhập để tiếp tục</p>
                        @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-600 text-white text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded bg-red-600 text-white">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 bg-[#1e1e1e] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="your@email.com">
                </div>
                
                <div class="mb-4">
                    <label for="mat_khau" class="block text-sm font-medium text-gray-300 mb-1">Mật khẩu</label>
                    <input type="password" id="mat_khau" name="mat_khau" class="w-full px-4 py-2 bg-[#1e1e1e] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="********">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-red-600 bg-[#1e1e1e] border-gray-600 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-400">Lưu đăng nhập</label>
                    </div>
                    <a href="#" class="text-sm text-red-500 hover:underline">Quên mật khẩu?</a>
                </div>
                
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">Đăng nhập</button>
            </form>
            
            <p class="text-center text-sm text-gray-400 mt-4">
                Chưa có tài khoản? <a href="/register" class="text-red-500 hover:underline">Đăng ký ngay</a>
            </p>
        </div>
    </main>

    <footer class="bg-[#1e1e1e] p-4 text-center text-gray-400">
        <p>&copy; 2025 MovieBooking. All rights reserved.</p>
    </footer>

</body>
</html>