<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietVeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chi_tiet_ve')->insert([
            ['ve_id' => 've001', 'ghe_id' => 'pc00140'],
            ['ve_id' => 've001', 'ghe_id' => 'pc00141'],
            ['ve_id' => 've002', 'ghe_id' => 'pc00207'],
            ['ve_id' => 've003', 'ghe_id' => 'pc00141'],
        ]);
    }
}
