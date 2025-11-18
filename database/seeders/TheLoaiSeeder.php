<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TheLoaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('the_loai')->insert([
            ['the_loai_id' => 'tl001', 'ten_the_loai' => 'Hành động'],
            ['the_loai_id' => 'tl002', 'ten_the_loai' => 'Tình cảm'],
            ['the_loai_id' => 'tl003', 'ten_the_loai' => 'Hài hước'],
            ['the_loai_id' => 'tl004', 'ten_the_loai' => 'Kinh dị'],
            ['the_loai_id' => 'tl005', 'ten_the_loai' => 'Hoạt hình'],
            ['the_loai_id' => 'tl006', 'ten_the_loai' => 'Tâm lý'],
            ['the_loai_id' => 'tl007', 'ten_the_loai' => 'Phiêu lưu'],
            ['the_loai_id' => 'tl008', 'ten_the_loai' => 'Khoa học viễn tưởng'],
        ]);
    }
}
