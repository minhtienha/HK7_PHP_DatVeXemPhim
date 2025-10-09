<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    protected $table = 'nguoi_dung';
    protected $primaryKey = 'nguoi_dung_id';
    public $timestamps = false;

    protected $fillable = [
        'ho_ten',
        'email',
        'so_dien_thoai',
        'mat_khau',
        'vai_tro'
    ];
}
