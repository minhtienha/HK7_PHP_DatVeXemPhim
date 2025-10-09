<?php

namespace App\Http\Controllers;

use App\Models\PhimTheLoai;
use Illuminate\Http\Request;

class PhimTheLoaiController extends Controller
{
    public function index()
    {
        $phimTheLoais = PhimTheLoai::all();
        return view('phim_the_loai.index', compact('phimTheLoais'));
    }

    public function show($phim_id, $the_loai_id)
    {
        $phimTheLoai = PhimTheLoai::where('phim_id', $phim_id)
            ->where('the_loai_id', $the_loai_id)
            ->first();
        return view('phim_the_loai.show', compact('phimTheLoai'));
    }
}
