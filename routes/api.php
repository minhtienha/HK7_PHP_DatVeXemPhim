<?php

use App\Http\Controllers\VeController;
use Illuminate\Support\Facades\Route;

Route::post('/tao_ve', [VeController::class, 'TaoVe_ChiTietVe']);
