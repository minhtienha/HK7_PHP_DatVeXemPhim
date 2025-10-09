<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGiaPhim extends Model
{
    protected $table = 'danh_gia_phim';
    protected $primaryKey = 'danh_gia_id';
    public $timestamps = false;

    protected $fillable = [
        'nguoi_dung_id',
        'phim_id',
        'diem',
        'binh_luan'
    ];
}
