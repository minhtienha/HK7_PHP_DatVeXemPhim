<?php

namespace App\Http\Controllers;

use App\Models\DanhGiaPhim;
use Illuminate\Http\Request;

class DanhGiaPhimController extends Controller
{
    public function index()
    {
        $danhGias = DanhGiaPhim::all();
        return view('danh_gia_phim.index', compact('danhGias'));
    }

    public function show($id)
    {
        $danhGia = DanhGiaPhim::find($id);
        return view('danh_gia_phim.show', compact('danhGia'));
    }
}
