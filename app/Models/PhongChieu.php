<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhongChieu extends Model
{
    protected $table = 'phong_chieu';
    protected $primaryKey = 'phong_id';
    public $timestamps = false;

    protected $fillable = [
        'ten_phong',
        'suc_chua'
    ];
}
