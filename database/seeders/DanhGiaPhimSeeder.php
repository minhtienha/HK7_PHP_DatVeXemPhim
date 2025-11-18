<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhGiaPhimSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('danh_gia_phim')->insert([
            [
                'danh_gia_id' => 'dg001',
                'nguoi_dung_id' => 'nd002',
                'phim_id' => 'p001',
                'diem' => 5,
                'binh_luan' => 'Phim quá hay, xem lại vẫn xúc động!',
                'ngay_tao' => now(),
            ],
            [
                'danh_gia_id' => 'dg002',
                'nguoi_dung_id' => 'nd003',
                'phim_id' => 'p002',
                'diem' => 4,
                'binh_luan' => 'Phim Việt Nam cảm động và ý nghĩa.',
                'ngay_tao' => now(),
            ],
            [
                'danh_gia_id' => 'dg003',
                'nguoi_dung_id' => 'nd004',
                'phim_id' => 'p003',
                'diem' => 5,
                'binh_luan' => 'Rất dễ thương, phù hợp cho trẻ em.',
                'ngay_tao' => now(),
            ],
        ]);
    }
}
