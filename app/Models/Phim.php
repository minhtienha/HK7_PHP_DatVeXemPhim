<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TheLoai;

class Phim extends Model

{
    /**
     * Lấy trạng thái phim từ cột trang_thai
     */
    public function getStatus()
    {
        return $this->trang_thai;
    }
    protected $table = 'phim';
    protected $primaryKey = 'phim_id';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'phim_id',
        'ten_phim',
        'mo_ta',
        'dao_dien',
        'dien_vien',
        'thoi_luong',
        'ngay_cong_chieu',
        'trang_thai',
        'hinh_anh'
    ];

    protected $casts = [
        'ngay_cong_chieu' => 'date',
        'ngay_tao' => 'datetime',
    ];

    public function theLoais()
    {
        return $this->belongsToMany(TheLoai::class, 'phim_the_loai', 'phim_id', 'the_loai_id');
    }

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
}
