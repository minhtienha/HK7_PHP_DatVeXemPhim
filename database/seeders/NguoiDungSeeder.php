<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NguoiDungSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nguoi_dung')->insert([
            [
                'nguoi_dung_id' => 'nd001',
                'ho_ten' => 'Admin',
                'email' => 'admin@gmail.com',
                'so_dien_thoai' => '0909000001',
                'mat_khau' => Hash::make('123456'),
                'vai_tro' => 'admin',
                'ngay_tao' => now(),
            ],
            [
                'nguoi_dung_id' => 'nd002',
                'ho_ten' => 'Nguyễn Văn A',
                'email' => 'vana@gmail.com',
                'so_dien_thoai' => '0909000002',
                'mat_khau' => Hash::make('123456'),
                'vai_tro' => 'khach_hang',
                'ngay_tao' => now(),
            ],
            [
                'nguoi_dung_id' => 'nd003',
                'ho_ten' => 'Trần Thị B',
                'email' => 'thib@gmail.com',
                'so_dien_thoai' => '0909000003',
                'mat_khau' => Hash::make('123456'),
                'vai_tro' => 'khach_hang',
                'ngay_tao' => now(),
            ],
            [
                'nguoi_dung_id' => 'nd004',
                'ho_ten' => 'Lê Minh C',
                'email' => 'minhc@gmail.com',
                'so_dien_thoai' => '0909000004',
                'mat_khau' => Hash::make('123456'),
                'vai_tro' => 'khach_hang',
                'ngay_tao' => now(),
            ],
        ]);
    }
}
