<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - MovieBooking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .text-red-600 {
            color: #dc2626;
        }
        .bg-red-600 {
            background-color: #dc2626;
        }
        .rounded-full {
            border-radius: 9999px;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

<!-- Header -->
<!-- Header -->
<header class="bg-white shadow-lg">
    <nav class="container mx-auto p-4 flex items-center">
        <a href="/" class="text-black text-3xl font-bold">MovieBooking</a>
        
        <div class="flex-grow text-right space-x-12">
            <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Trang chủ</a>
            <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Phim</a>
            <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Rạp chiếu</a>
            <a href="#" class="text-lg font-semibold text-gray-700 hover:text-black">Vé của tôi</a>
        </div>

        <div class="ml-12 text-lg">
            @auth
                <!-- Khi đã đăng nhập -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile') }}" class="text-black font-semibold hover:underline">
                        Chào, {{ Auth::user()->ho_ten }}!
                    </a>


                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-full text-lg transition">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            @else
                <!-- Khi chưa đăng nhập -->
                <a href="{{ route('login') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-full text-lg transition">
                    Đăng nhập
                </a>
            @endauth
        </div>
    </nav>
</header>


    <main class="flex-grow container mx-auto p-6">
        <h1 class="text-3xl font-bold text-black mb-6">Đang chiếu</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          @foreach($phims as $phim)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative w-full h-96 overflow-hidden">
                        <img src="{{ asset('assets/' . $phim->hinh_anh) }}" alt="{{ $phim->ten_phim }}" class="w-full h-full object-cover">
                        
                        <div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            Chưa có đánh giá
                        </div>
                    </div>
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-black">{{ $phim->ten_phim }}</h2>
                        
                        {{-- Thêm phần hiển thị thể loại --}}
                        <p class="text-sm text-gray-600">
                            @foreach ($phim->theLoais as $theLoai)
                                {{ $theLoai->ten_the_loai }}@if (!$loop->last), @endif
                            @endforeach
                        </p>

                        <div class="mt-2 text-sm text-gray-500">
                            <div class="flex items-center space-x-1">
                                <span>{{ $phim->thoi_luong }} phút</span>
                            </div>
                            <div class="mt-1 text-xs text-gray-400">
                                {{ $phim->ngay_cong_chieu }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

<footer class="bg-gray-800 text-white py-8 shadow-lg">
    <div class="container mx-auto px-4 text-center text-gray-400">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold text-white mb-4">Liên hệ</h3>
                <p class="text-sm">
                    Địa chỉ: Số 123, đường ABC, Quận XYZ, TP.HCM
                </p>
                <p class="text-sm">
                    Email: support@moviebooking.com
                </p>
                <p class="text-sm">
                    Điện thoại: 1900-1234
                </p>
            </div>

            <div>
                <h3 class="text-xl font-bold text-white mb-4">Liên kết</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm hover:text-red-500">Về chúng tôi</a></li>
                    <li><a href="#" class="text-sm hover:text-red-500">Điều khoản sử dụng</a></li>
                    <li><a href="#" class="text-sm hover:text-red-500">Chính sách bảo mật</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-bold text-white mb-4">Kết nối với chúng tôi</h3>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-500">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14 11.5h2.5l.5-2.5H14V7c0-.55.45-1 1-1h1.5V3h-2.5c-2.4 0-4 1.4-4 4v2.5H6.5V12h2v12h5V12h3l1-2.5h-4V11.5z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.34-1.6.56-2.47.66.88-.53 1.56-1.37 1.88-2.37-.83.5-1.74.87-2.73 1.07-1.77-1.89-4.88-1.57-6.2 1.45-1.5 3.32-3.88 6.5-6.52 6.5s-4.78-.5-6.72-2.1c-.88 2.27-2.6 4.1-4.77 5.09 3.03 2.5 6.7.75 8.78-1.12-2.35 0-4.32-1.37-5.55-3.4s-1.8-4.43-1.8-6.9a.83.83 0 01.07-.4c1.1.58 2.37.94 3.73.96-2.02-1.35-3.35-3.64-3.35-6.18 0-1.28.32-2.47.9-3.52a9.14 9.14 0 006.63 3.35c.16-1.38.6-2.67 1.34-3.83 1.25-2.03 3.4-3.33 5.86-3.35 1.57 0 3.02.66 4.14 1.74a9.04 9.04 0 012.7-1.04c.83-.17 1.68-.26 2.53-.25z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-pink-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.16c3.15 0 3.51.01 4.76.07 1.25.06 1.9.26 2.45.47a3.46 3.46 0 011.23.82 3.46 3.46 0 01.82 1.23c.21.55.41 1.2.47 2.45.06 1.25.07 1.61.07 4.76s-.01 3.51-.07 4.76c-.06 1.25-.26 1.9-.47 2.45a3.46 3.46 0 01-.82 1.23 3.46 3.46 0 01-1.23.82c-.55.21-1.2.41-2.45.47-1.25.06-1.61.07-4.76.07s-3.51-.01-4.76-.07c-1.25-.06-1.9-.26-2.45-.47a3.46 3.46 0 01-1.23-.82 3.46 3.46 0 01-.82-1.23c-.21-.55-.41-1.2-.47-2.45-.06-1.25-.07-1.61-.07-4.76s.01-3.51.07-4.76c.06-1.25.26-1.9.47-2.45a3.46 3.46 0 01.82-1.23A3.46 3.46 0 016.79 2.7c.55-.21 1.2-.41 2.45-.47C10.49 2.16 10.85 2.16 12 2.16zM12 0C8.74 0 8.32.01 7.02.07 5.72.13 4.8.35 4.02.66a5.53 5.53 0 00-1.8.94c-.6.43-1.12 1.05-1.5 1.76a5.53 5.53 0 00-.94 1.8c-.31.81-.53 1.73-.66 3.03-.06 1.29-.07 1.72-.07 5.02s.01 3.73.07 5.02c.13 1.29.35 2.21.66 3.03a5.53 5.53 0 00.94 1.8c.43.6.95 1.12 1.76 1.5.81.31 1.73.53 3.03.66 1.29.06 1.72.07 5.02.07s3.73-.01 5.02-.07c1.29-.13 2.21-.35 3.03-.66a5.53 5.53 0 001.8-.94c.43-.6 1.05-1.12 1.76-1.5-.81-.31-1.73-.53-3.03-.66C15.75.01 15.34 0 12 0zM12 7.74a4.26 4.26 0 100 8.52 4.26 4.26 0 000-8.52zM12 14.28a2.28 2.28 0 110-4.56 2.28 2.28 0 010 4.56zM17.43 5.8a1.01 1.01 0 10-2.02 0 1.01 1.01 0 002.02 0z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-8 pt-4 border-t border-gray-600">
            <p>&copy; 2025 MovieBooking. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>