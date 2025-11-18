<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ve extends Model
{
    protected $table = 've';
    protected $primaryKey = 've_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        've_id',
        'nguoi_dung_id',
        'suat_chieu_id',
        'thoi_gian_dat',
        'tong_tien'
    ];

    protected $casts = [
        'thoi_gian_dat' => 'datetime',
    ];

    public function chiTietVe()
    {
        return $this->hasMany(ChiTietVe::class, 've_id', 've_id');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id', 'nguoi_dung_id');
    }

    public function suatChieu()
    {
        return $this->belongsTo(SuatChieu::class, 'suat_chieu_id', 'suat_chieu_id');
    }

    public function gheNgoi()
    {
        return $this->belongsToMany(GheNgoi::class, 'chi_tiet_ve', 've_id', 'ghe_id');
    }
}
