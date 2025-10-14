<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/tao_ve',
        'tao_ve',
        'https://e0dfb7d52bc4.ngrok-free.app/tao_ve',
        'https://e0dfb7d52bc4.ngrok-free.app/*',
        '*',
    ];
}
