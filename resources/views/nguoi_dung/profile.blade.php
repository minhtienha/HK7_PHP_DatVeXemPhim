<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .text-red-600 {
            color: #dc2626;
        }
        .bg-red-600 {
            background-color: #dc2626;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <header class="bg-white shadow-lg">
        <nav class="container mx-auto p-4 flex items-center">
            <a href="/" class="text-black text-3xl font-bold">MovieBooking</a>
            <div class="flex-grow text-right space-x-12">
                <a href="/" class="text-lg font-semibold text-gray-700 hover:text-black">Trang chủ</a>
                <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Phim</a>
                <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Rạp chiếu</a>
                <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Vé của tôi</a>
            </div>
            <div class="ml-12 text-lg">
                @auth
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('profile') }}" class="text-black font-semibold hover:underline">
                            Chào, {{ Auth::user()->ho_ten }}!
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-full text-lg">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-full text-lg">
                        Đăng nhập
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="flex-grow container mx-auto p-6 flex">
        <div class="w-1/4 bg-white p-6 rounded-lg shadow-lg flex flex-col items-center mr-6">
            <div class="w-24 h-24 bg-red-600 text-white text-4xl font-bold flex items-center justify-center rounded-full mb-4">
                {{ substr(Auth::user()->ho_ten, 0, 1) }}
            </div>
            <h3 class="text-2xl font-bold text-black">{{ Auth::user()->ho_ten }}</h3>
            <p class="text-sm text-gray-500 mb-6">{{ Auth::user()->email }}</p>
            
            <a href="{{ route('profile') }}" class="w-full text-left p-3 rounded-lg bg-red-600 text-white font-semibold flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                Thông tin cá nhân
            </a>
            <a href="#" class="w-full text-left p-3 rounded-lg hover:bg-gray-200 text-gray-700 font-semibold flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9 12h-1v-1a1 1 0 011-1h1a1 1 0 011 1v1h-1a1 1 0 01-1-1zM10 18a8 8 0 100-16 8 8 0 000 16zm1-14a1 1 0 11-2 0 1 1 0 012 0zm-2 1a2 2 0 100 4 2 2 0 000-4zm4 4a2 2 0 100 4 2 2 0 000-4zm-4 4a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                Vé đã đặt
            </a>
            <a href="#" class="w-full text-left p-3 rounded-lg hover:bg-gray-200 text-gray-700 font-semibold flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.649-.921 1.958 0l1.378 4.254a1 1 0 00.95.691h4.482c.969 0 1.372 1.24.588 1.81l-3.633 2.641a1 1 0 00-.36.79l1.378 4.254c.3.921-.755 1.688-1.543 1.111l-3.633-2.641a1 1 0 00-1.176 0l-3.633 2.641c-.788.57-.381-1.81.588-1.81h4.482a1 1 0 00.95-.691l1.378-4.254a1 1 0 00-.36-.79l-3.633-2.641c-.784-.57-.381-1.81.588-1.81h4.482a1 1 0 00.95-.691l1.378-4.254z"></path></svg>
                Đánh giá của tôi
            </a>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full text-left p-3 rounded-lg hover:bg-red-100 text-gray-700 hover:text-red-600 font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M11 16a1 1 0 01-1 1H4a1 1 0 01-1-1v-5a1 1 0 011-1h6a1 1 0 011 1v5zm-2-7a1 1 0 00-1-1H4a1 1 0 00-1 1v5a1 1 0 001 1h6a1 1 0 001-1v-5zm-2-4a1 1 0 011-1h6a1 1 0 011 1v5a1 1 0 01-1 1h-6a1 1 0 01-1-1v-5zm2-1a1 1 0 00-1 1v5a1 1 0 001 1h6a1 1 0 001-1v-5a1 1 0 00-1-1h-6zM13 3a1 1 0 011-1h5a1 1 0 011 1v5a1 1 0 01-1 1h-5a1 1 0 01-1-1V3zm2 1a1 1 0 00-1 1v5a1 1 0 001 1h5a1 1 0 001-1V4a1 1 0 00-1-1h-5z"></path></svg>
                    Đăng xuất
                </button>
            </form>
        </div>

        <div class="w-3/4 bg-white p-8 rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-black mb-6">Thông tin cá nhân</h3>
            <form action="{{ route('profile') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="ho_ten" class="block text-sm font-medium text-gray-700">Họ và tên</label>
                        <input type="text" id="ho_ten" name="ho_ten" value="{{ Auth::user()->ho_ten }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="so_dien_thoai" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                        <input type="tel" id="so_dien_thoai" name="so_dien_thoai" value="{{ Auth::user()->so_dien_thoai }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="mat_khau_moi" class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                        <input type="password" id="mat_khau_moi" name="mat_khau_moi" placeholder="Để trống nếu không muốn đổi" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Chỉnh sửa
                    </button>
                </div>
            </form>
        </div>
    </main>
    
    <footer class="bg-gray-800 text-white py-8 shadow-lg mt-auto">
        <div class="container mx-auto px-4 text-center text-gray-400">
            <p>&copy; 2025 MovieBooking. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>