<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Authenticatable
{
    use Notifiable;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'nguoi_dung_id';
    public $incrementing = false;      // vì khóa là string (nd001) không auto-increment
    protected $keyType = 'string';

    public $timestamps = false; // nếu bạn không dùng created_at/updated_at


    protected $fillable = [
        'nguoi_dung_id', 
        'ho_ten', 'email', 
        'so_dien_thoai', 
        'mat_khau', 
        'vai_tro'
    ];
    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function getAuthPasswordName()
    {
        return 'mat_khau';
    }

    // nếu muốn khi dùng create(['mat_khau' => 'plain']) tự hash (Laravel 10+ hỗ trợ 'hashed')
    protected $casts = [
        // 'mat_khau' => 'hashed',
    ];

    // nếu cần, override để Auth lấy password đúng cột
    public function getAuthPassword() 
    {
        return $this->mat_khau;
    }

}
