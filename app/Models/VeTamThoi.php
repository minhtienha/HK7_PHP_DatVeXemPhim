<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VeTamThoi extends Model
{
    protected $table = 've_tam_thoi';
    protected $primaryKey = 've_id';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        've_id',
        'nguoi_dung_id',
        'suat_chieu_id',
        'thoi_gian_dat',
        'tong_tien'
    ];
}
