<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGiaPhim extends Model
{
    protected $table = 'danh_gia_phim';
    protected $primaryKey = 'danh_gia_id';
    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'danh_gia_id',
        'nguoi_dung_id',
        'phim_id',
        'diem',
        'binh_luan'
    ];

    protected $casts = [
        'ngay_tao' => 'datetime',
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
