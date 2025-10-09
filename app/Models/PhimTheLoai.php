<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhimTheLoai extends Model
{
    protected $table = 'phim_the_loai';
    public $incrementing = false; // vì primary key là composite (phim_id + the_loai_id)
    public $timestamps = false;
    protected $fillable = [
        'phim_id',
        'the_loai_id'
    ];
}
