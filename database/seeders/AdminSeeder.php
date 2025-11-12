<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo tài khoản admin
        DB::table('nguoi_dung')->insert([
            'nguoi_dung_id' => 'ADMIN001',
            'ho_ten' => 'Admin Test',
            'email' => 'admin@test.com',
            'mat_khau' => Hash::make('admin123'),
            'vai_tro' => 'admin',
            'so_dien_thoai' => '0123456789',
        ]);

        $this->command->info('✅ Đã tạo tài khoản admin: admin@test.com / admin123');
    }
}
