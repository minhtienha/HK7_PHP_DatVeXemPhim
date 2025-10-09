<?php

namespace App\Http\Controllers;

use App\Models\ChiTietVe;
use Illuminate\Http\Request;

class ChiTietVeController extends Controller
{
    public function index()
    {
        $chiTiets = ChiTietVe::all();
        return view('chi_tiet_ve.index', compact('chiTiets'));
    }

    public function show($ve_id, $ghe_id)
    {
        $chiTiet = ChiTietVe::where('ve_id', $ve_id)
            ->where('ghe_id', $ghe_id)
            ->first();
        return view('chi_tiet_ve.show', compact('chiTiet'));
    }
}
