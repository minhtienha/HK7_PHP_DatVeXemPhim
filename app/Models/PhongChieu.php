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
    protected $fillable = ['phong_id', 'ten_phong', 'suc_chua'];
    public $timestamps = false;

    public function gheNgoi()
    {
        return $this->hasMany(GheNgoi::class, 'phong_id', 'phong_id');
    }
}
