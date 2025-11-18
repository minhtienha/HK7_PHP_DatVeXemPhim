<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuatChieuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suat_chieu')->insert([
            [
                'suat_chieu_id' => 'sc001',
                'phim_id' => 'p001',
                'phong_id' => 'pc001',
                'gia_ve' => 80000,
                'ngay_chieu' => '2025-10-13',
                'gio_bat_dau' => '18:00:00',
                'gio_ket_thuc' => '21:00:00',
                'trang_thai' => 'sap_chieu',
                'ngay_tao' => now(),
            ],
            [
                'suat_chieu_id' => 'sc002',
                'phim_id' => 'p001',
                'phong_id' => 'pc002',
                'gia_ve' => 90000,
                'ngay_chieu' => '2025-10-13',
                'gio_bat_dau' => '21:30:00',
                'gio_ket_thuc' => '00:30:00',
                'trang_thai' => 'sap_chieu',
                'ngay_tao' => now(),
            ],
            [
                'suat_chieu_id' => 'sc003',
                'phim_id' => 'p002',
                'phong_id' => 'pc003',
                'gia_ve' => 70000,
                'ngay_chieu' => '2025-10-14',
                'gio_bat_dau' => '17:00:00',
                'gio_ket_thuc' => '19:00:00',
                'trang_thai' => 'sap_chieu',
                'ngay_tao' => now(),
            ],
            [
                'suat_chieu_id' => 'sc004',
                'phim_id' => 'p003',
                'phong_id' => 'pc001',
                'gia_ve' => 75000,
                'ngay_chieu' => '2025-10-17',
                'gio_bat_dau' => '15:00:00',
                'gio_ket_thuc' => '16:45:00',
                'trang_thai' => 'sap_chieu',
                'ngay_tao' => now(),
            ],
        ]);
    }
}
