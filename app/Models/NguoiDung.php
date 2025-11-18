<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Authenticatable
{
    use Notifiable;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'nguoi_dung_id';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'nguoi_dung_id',
        'ho_ten',
        'email',
        'so_dien_thoai',
        'mat_khau',
        'vai_tro'
    ];

    protected $hidden = [
        'mat_khau',
    ];

    protected $casts = [
        'ngay_tao' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function getAuthPasswordName()
    {
        return 'mat_khau';
    }

    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    // Relationships
    public function ve()
    {
        return $this->hasMany(Ve::class, 'nguoi_dung_id', 'nguoi_dung_id');
    }

    public function danhGia()
    {
        return $this->hasMany(DanhGiaPhim::class, 'nguoi_dung_id', 'nguoi_dung_id');
    }
}
