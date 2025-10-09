<?php

namespace App\Http\Controllers;

use App\Models\SuatChieu;
use Illuminate\Http\Request;

class SuatChieuController extends Controller
{
    public function index()
    {
        $suatChieus = SuatChieu::all();
        return view('suat_chieu.index', compact('suatChieus'));
    }

    public function show($id)
    {
        $suatChieu = SuatChieu::find($id);
        return view('suat_chieu.show', compact('suatChieu'));
    }
}
