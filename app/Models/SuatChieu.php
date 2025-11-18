<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuatChieu extends Model
{
    protected $table = 'suat_chieu';
    protected $primaryKey = 'suat_chieu_id';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'suat_chieu_id',
        'phim_id',
        'phong_id',
        'gia_ve',
        'ngay_chieu',
        'gio_bat_dau',
        'gio_ket_thuc',
        'trang_thai'
    ];

    protected $casts = [
        'ngay_chieu' => 'date',
        'ngay_tao' => 'datetime',
    ];

    public function phim()
    {
        return $this->belongsTo(Phim::class, 'phim_id', 'phim_id');
    }

    public function phongChieu()
    {
        return $this->belongsTo(PhongChieu::class, 'phong_id', 'phong_id');
    }

    public function ve()
    {
        return $this->hasMany(Ve::class, 'suat_chieu_id', 'suat_chieu_id');
    }
}
