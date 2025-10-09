<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ve extends Model
{
    protected $table = 've';
    protected $primaryKey = 've_id';
    public $timestamps = false;

    protected $fillable = [
        'nguoi_dung_id',
        'suat_chieu_id',
        'thoi_gian_dat',
        'tong_tien'
    ];
}
