<?php

namespace App\Http\Controllers;

use App\Models\Phim;
use App\Models\TheLoai;
use App\Models\SuatChieu;
use App\Models\Ve;
use Illuminate\Http\Request;

class PhimController extends Controller
{
    public function index()
    {
        $phims = Phim::with('theLoais')->get();

        // Nếu file là resources/views/phim/index.blade.php
        return view('phim.index', compact('phims'));
       
    }

    public function show($phim_id)
    {
        $phim = Phim::with(['danhGia.nguoiDung', 'suatChieu.phongChieu', 'theLoai'])->find($phim_id);
        return view('pages.detail', compact('phim'));
    }
}