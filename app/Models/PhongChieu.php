<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongChieu extends Model
{
    use HasFactory;

    protected $table = 'phong_chieu';
    protected $primaryKey = 'phong_id';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = ['phong_id', 'ten_phong', 'suc_chua'];

    protected $casts = [
        'ngay_tao' => 'datetime',
    ];

    public function gheNgoi()
    {
        return $this->hasMany(GheNgoi::class, 'phong_id', 'phong_id');
    }

    public function suatChieu()
    {
        return $this->hasMany(SuatChieu::class, 'phong_id', 'phong_id');
    }
}
