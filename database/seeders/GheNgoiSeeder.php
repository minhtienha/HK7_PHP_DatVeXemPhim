<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PhongChieu;
use App\Models\GheNgoi;

class GheNgoiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả phòng chiếu
        $phongChieus = PhongChieu::all();

        foreach ($phongChieus as $phong) {
            // Sinh ghế cho từng phòng dựa trên suc_chua
            for ($i = 1; $i <= $phong->suc_chua; $i++) {
                GheNgoi::create([
                    'ghe_id' => $phong->phong_id . str_pad($i, 2, '0', STR_PAD_LEFT), // Tạo ghe_id tự động
                    'phong_id' => $phong->phong_id,
                    'so_ghe' => $phong->phong_id . str_pad($i, 2, '0', STR_PAD_LEFT), // Ví dụ: A01, A02, ..., B01, B02, ...
                ]);
            }
        }
    }
}
