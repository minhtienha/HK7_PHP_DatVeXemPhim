<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhimTheLoaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('phim_the_loai')->insert([
            ['phim_id' => 'p001', 'the_loai_id' => 'tl001'],
            ['phim_id' => 'p002', 'the_loai_id' => 'tl001'],
            ['phim_id' => 'p002', 'the_loai_id' => 'tl007'],
            ['phim_id' => 'p002', 'the_loai_id' => 'tl008'],
            ['phim_id' => 'p003', 'the_loai_id' => 'tl002'],
            ['phim_id' => 'p003', 'the_loai_id' => 'tl003'],
            ['phim_id' => 'p004', 'the_loai_id' => 'tl002'],
            ['phim_id' => 'p004', 'the_loai_id' => 'tl003'],
            ['phim_id' => 'p004', 'the_loai_id' => 'tl006'],
        ]);
    }
}
