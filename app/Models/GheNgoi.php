<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GheNgoi extends Model
{
    protected $table = 'ghe_ngoi';
    protected $primaryKey = 'ghe_id';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ghe_id',
        'phong_id',
        'so_ghe'
    ];

    public function phongChieu()
    {
        return $this->belongsTo(PhongChieu::class, 'phong_id', 'phong_id');
    }

    public function ve()
    {
        return $this->belongsToMany(Ve::class, 'chi_tiet_ve', 'ghe_id', 've_id');
    }
}
