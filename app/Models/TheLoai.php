<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    protected $table = 'the_loai';
    protected $primaryKey = 'the_loai_id';
    public $timestamps = false;

    protected $fillable = [
        'ten_the_loai'
    ];
}
