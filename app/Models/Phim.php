<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phim extends Model
{
    protected $table = 'phim';
    protected $primaryKey = 'phim_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ten_phim',
        'mo_ta',
        'dao_dien',
        'dien_vien',
        'thoi_luong',
        'ngay_cong_chieu',
        'trang_thai',
        'hinh_anh'
    ];

    public function phimTheLoai()
    {
        return $this->hasMany(PhimTheLoai::class, 'phim_id', 'phim_id');
    }

    public function danhGia()
    {
        return $this->hasMany(DanhGiaPhim::class, 'phim_id', 'phim_id');
    }

    public function suatChieu()
    {
        return $this->hasMany(SuatChieu::class, 'phim_id', 'phim_id');
    }

    public function theLoai()
    {
        return $this->belongsToMany(TheLoai::class, 'phim_the_loai', 'phim_id', 'the_loai_id');
    }
}
