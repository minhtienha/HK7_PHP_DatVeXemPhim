<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietVe extends Model
{
    protected $table = 'chi_tiet_ve';
    public $incrementing = false; // primary key composite (ve_id + ghe_id)
    public $timestamps = false;

    protected $fillable = [
        've_id',
        'ghe_id'
    ];
}
