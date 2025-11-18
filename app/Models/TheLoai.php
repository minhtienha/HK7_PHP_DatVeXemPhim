<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    protected $table = 'the_loai';
    protected $primaryKey = 'the_loai_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'the_loai_id',
        'ten_the_loai'
    ];

    // Relationships
    public function phims()
    {
        return $this->belongsToMany(Phim::class, 'phim_the_loai', 'the_loai_id', 'phim_id');
    }
}
