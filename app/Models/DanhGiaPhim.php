<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGiaPhim extends Model
{
    protected $table = 'danh_gia_phim';
    protected $primaryKey = 'danh_gia_id';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'danh_gia_id',
        'nguoi_dung_id',
        'phim_id',
        'diem',
        'binh_luan'
    ];

    public function phim()
    {
        return $this->belongsTo(Phim::class, 'phim_id', 'phim_id');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id', 'nguoi_dung_id');
    }
}
