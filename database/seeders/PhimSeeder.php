<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhimSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('phim')->insert([
            [
                'phim_id' => 'p001',
                'ten_phim' => 'TỬ CHIẾN TRÊN KHÔNG',
                'mo_ta' => 'Tử Chiến Trên Không là phim điện ảnh hành động - kịch tính, được lấy cảm hứng từ vụ cướp máy bay có thật tại Việt Nam sau năm 1975. Đón xem hành động Việt Nam kịch tính nhất tháng 9 này!',
                'dao_dien' => 'Hàm Trần',
                'dien_vien' => 'Thái Hòa, Kaity Nguyễn, Thanh Sơn, Xuân Phúc, Võ Điền Gia Huy, Trần Ngọc Vàng, Ma Ran Đô, Lợi Trần, Trâm Anh, Xuân Văn, Bảo Định, Ray Nguyễn...',
                'thoi_luong' => 118,
                'ngay_cong_chieu' => '2025-09-19',
                'trang_thai' => 'dang_chieu',
                'hinh_anh' => 'tuchientrenkhong.jpg',
                'ngay_tao' => now(),
            ],
            [
                'phim_id' => 'p002',
                'ten_phim' => 'AVATAR: DÒNG CHẢY CỦA NƯỚC (CHIẾU LẠI)',
                'mo_ta' => 'Avatar: Dòng Chảy Của Nước tái chiếu tạo rạp DUY NHẤT 01 TUẦN từ 03.10.2025 với định dạng 3D - IMAX 3D và cả 4DX 3D Nhất định không thể bỏ lỡ trải nghiệm điện ảnh này, lưu lịch đặt vé ngay!',
                'dao_dien' => 'James Cameron',
                'dien_vien' => 'Sam Worthington, Zoe Saldana, Dương Tử Quỳnh,...',
                'thoi_luong' => 196,
                'ngay_cong_chieu' => '2025-10-02',
                'trang_thai' => 'dang_chieu',
                'hinh_anh' => 'avatar_dongchaycuanuoc.jpg',
                'ngay_tao' => now(),
            ],
            [
                'phim_id' => 'p003',
                'ten_phim' => 'TAY ANH GIỮ MỘT VÌ SAO',
                'mo_ta' => 'Siêu sao Kang Jun Woo – "Hoàng tử Châu Á" – rơi vào tình cảnh "mắc kẹt" tại Việt Nam sau một loạt sự cố dở khóc dở cười, nơi anh gặp Thảo – một cô gái bán cà phê đầy đam mê, quyết tâm theo đuổi ước mơ của mình.',
                'dao_dien' => 'Kim Sung Hoon',
                'dien_vien' => 'Lee Kwang Soo, Hoàng Hà, Duy Khánh, Cù Thị Trà, Um Mun Suk, Lâm Thanh Mỹ,...',
                'thoi_luong' => 117,
                'ngay_cong_chieu' => '2025-10-03',
                'trang_thai' => 'dang_chieu',
                'hinh_anh' => 'tayanhgiumotvisao.jpg',
                'ngay_tao' => now(),
            ],
            [
                'phim_id' => 'p004',
                'ten_phim' => 'CHỊ NGÃ EM NÂNG',
                'mo_ta' => '',
                'dao_dien' => 'Vũ Thành Vinh',
                'dien_vien' => 'Lê Khánh, Quốc Trường, Thuận Nguyễn, Uyển Ân',
                'thoi_luong' => 122,
                'ngay_cong_chieu' => '2025-10-03',
                'trang_thai' => 'dang_chieu',
                'hinh_anh' => 'chingaemnang.jpg',
                'ngay_tao' => now(),
            ],
            [
                'phim_id' => 'p005',
                'ten_phim' => 'TEE YOD: QUỶ ĂN TẠNG PHẦN 3',
                'mo_ta' => 'Yak và gia đình phải đối mặt với nỗi kinh hoàng mới khi "Yee" – cô em út – đột ngột mất tích bí ẩn. Yak buộc phải cùng Yos, Yod và Papan lên đường đến "Bong Sa Noh Bian" – khu rừng ma ám – để cứu Yee trước khi những linh hồn tà ác một lần nữa bị đánh thức.',
                'dao_dien' => 'Narit Yuvaboon',
                'dien_vien' => 'Nadech Kugimiya, Denise Jelilcha Kapaun, Mim Rattawadee Wongthong, Junior Kajbhunditt Jaidee, Friend Peerakrit Phacharaboonyakiat',
                'thoi_luong' => 104,
                'ngay_cong_chieu' => '2025-10-10',
                'trang_thai' => 'sap_chieu',
                'hinh_anh' => 'quyantang3.jpg',
                'ngay_tao' => now(),
            ],
            [
                'phim_id' => 'p006',
                'ten_phim' => 'CỤC VÀNG CỦA NGOẠI',
                'mo_ta' => 'Lấy cảm hứng từ những ký ức tuổi thơ ngọt ngào, "Cục Vàng Của Ngoại" mang đến câu chuyện ấm áp về tình bà cháu trong một xóm nhỏ chan chứa nghĩa tình. Bà Hậu – người phụ nữ cả đời tần tảo, nay trở thành chỗ dựa duy nhất của cháu ngoại khi con gái bỏ đi. Dẫu cuộc sống còn nhiều nhọc nhằn, tình thương bà dành cho cháu vẫn luôn trọn vẹn. Với bà, cháu là "cục vàng" – niềm vui, niềm an ủi và cũng là lẽ sống của đời mình. Bộ phim nhẹ nhàng dẫn khán giả trở lại những khoảnh khắc quen thuộc nơi xóm nhỏ: nụ cười hồn nhiên của cháu, vòng tay chở che của bà và sự đùm bọc từ hàng xóm láng giềng. Tất cả cùng hòa thành một bức tranh đời thường ấm áp, gợi nhắc về tuổi thơ bình yên và tình người mộc mạc, chân thành.',
                'dao_dien' => 'Khương Ngọc',
                'dien_vien' => 'Việt Hương, Hồng Đào, Lê Khánh, Băng Di, Lâm Thanh Mỹ, Hữu Châu, Tuấn Khải, Thư Đan, Panda',
                'thoi_luong' => null,
                'ngay_cong_chieu' => '2025-10-17',
                'trang_thai' => 'sap_chieu',
                'hinh_anh' => 'cucvangcuangoai.jpg',
                'ngay_tao' => now(),
            ],
            [
                'phim_id' => 'p007',
                'ten_phim' => 'NĂM CỦA ANH, NGÀY CỦA EM',
                'mo_ta' => 'Khi thế giới bị chia cắt thành 2 chiều không gian song song, tình yêu nảy nở giữa Hứa Quang Hán và Viên Lễ Lâm bị cuốn trôi theo hai nhịp sống khác biệt. Họ vẫn níu giữ sợi dây mong manh của định mệnh, cố tìm đến điểm giao nhau giữa hai thế giới để viết tiếp chuyện tình còn dang dở. Một bản tình ca lặng lẽ và day dứt, nơi Hứa Quang Hán nhẹ nhàng mang đến những nốt lặng bồi hồi, liệu tình yêu có đủ để vượt qua giới hạn của không gian và thời gian?',
                'dao_dien' => 'Kung Siu Ping',
                'dien_vien' => 'Hsu Kuang Han; Angela Yuen',
                'thoi_luong' => 112,
                'ngay_cong_chieu' => '2025-10-17',
                'trang_thai' => 'sap_chieu',
                'hinh_anh' => 'namcuaanhngaycuaem.jpg',
                'ngay_tao' => now(),
            ],
            [
                'phim_id' => 'p008',
                'ten_phim' => 'CẢI MA',
                'mo_ta' => 'Khi đại gia đình ông Quang trở về quê để thực hiện nghi lễ cải táng đã bị trì hoãn quá lâu, họ không chỉ đối diện với những nghi thức tâm linh, mà còn vô tình khơi dậy vòng xoáy nghiệp báo truyền đời.',
                'dao_dien' => 'Thắng Vũ',
                'dien_vien' => 'Rima Thanh Vy, Hoàng Phúc, Thúy Hạnh, Avin Lu, Kim Hải, Lâm Thanh Nhã, Kiều Trinh, Hoàng Mèo, Kim Long,…',
                'thoi_luong' => null,
                'ngay_cong_chieu' => '2025-10-24',
                'trang_thai' => 'sap_chieu',
                'hinh_anh' => 'caima.jpg',
                'ngay_tao' => now(),
            ],
        ]);
    }
}
