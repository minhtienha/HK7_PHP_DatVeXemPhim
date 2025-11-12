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
}
