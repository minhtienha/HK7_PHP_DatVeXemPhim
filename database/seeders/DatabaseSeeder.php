<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            NguoiDungSeeder::class,
            TheLoaiSeeder::class,
            PhimSeeder::class,
            PhimTheLoaiSeeder::class,
            PhongChieuSeeder::class,
            GheNgoiSeeder::class,
            SuatChieuSeeder::class,
            VeSeeder::class,
            ChiTietVeSeeder::class,
            DanhGiaPhimSeeder::class,
        ]);
    }
}
