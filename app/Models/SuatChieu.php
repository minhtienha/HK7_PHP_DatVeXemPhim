<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuatChieu extends Model
{
    protected $table = 'suat_chieu';
    protected $primaryKey = 'suat_chieu_id';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'phim_id',
        'phong_id',
        'gia_ve',
        'ngay_chieu',
        'gio_bat_dau',
        'gio_ket_thuc',
        'trang_thai'
    ];

    public function phim()
    {
        return $this->belongsTo(Phim::class, 'phim_id', 'phim_id');
    }

    public function phongChieu()
    {
        return $this->belongsTo(PhongChieu::class, 'phong_id', 'phong_id');
    }
}
