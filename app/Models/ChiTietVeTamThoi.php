<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietVeTamThoi extends Model
{
    protected $table = 'chi_tiet_ve_tam_thoi';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        've_id',
        'ghe_id'
    ];

    public function ghe()
    {
        return $this->belongsTo(GheNgoi::class, 'ghe_id', 'ghe_id');
    }
}
