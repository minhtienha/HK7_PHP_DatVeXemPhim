<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ve')->insert([
            [
                've_id' => 've001',
                'nguoi_dung_id' => 'nd002',
                'suat_chieu_id' => 'sc001',
                'thoi_gian_dat' => now(),
                'tong_tien' => 160000,
            ],
            [
                've_id' => 've002',
                'nguoi_dung_id' => 'nd003',
                'suat_chieu_id' => 'sc003',
                'thoi_gian_dat' => now(),
                'tong_tien' => 70000,
            ],
            [
                've_id' => 've003',
                'nguoi_dung_id' => 'nd004',
                'suat_chieu_id' => 'sc002',
                'thoi_gian_dat' => now(),
                'tong_tien' => 90000,
            ],
        ]);
    }
}
