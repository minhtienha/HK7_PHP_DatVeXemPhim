<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\TheLoai;

class Phim extends Model
{
    protected $table = 'phim';
    protected $primaryKey = 'phim_id';
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
    public function theLoais()
    {
        return $this->belongsToMany(TheLoai::class, 'phim_the_loai', 'phim_id', 'the_loai_id');
    }
}
