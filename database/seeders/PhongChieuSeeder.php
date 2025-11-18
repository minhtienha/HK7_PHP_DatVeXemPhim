<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhongChieuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('phong_chieu')->insert([
            [
                'phong_id' => 'pc001',
                'ten_phong' => 'Phòng 1',
                'suc_chua' => 50,
                'ngay_tao' => now(),
            ],
            [
                'phong_id' => 'pc002',
                'ten_phong' => 'Phòng 2',
                'suc_chua' => 70,
                'ngay_tao' => now(),
            ],
            [
                'phong_id' => 'pc003',
                'ten_phong' => 'Phòng 3',
                'suc_chua' => 60,
                'ngay_tao' => now(),
            ],
        ]);
    }
}
