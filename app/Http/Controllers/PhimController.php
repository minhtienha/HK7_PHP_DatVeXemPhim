<?php

namespace App\Http\Controllers;

use App\Models\Phim;
use App\Models\SuatChieu;
use App\Models\Ve;
use Illuminate\Http\Request;

class PhimController extends Controller
{
    public function index()
    {
        $phims = Phim::all();
        return view('pages.index', compact('phims'));
    }

    public function show($phim_id)
    {
        $phim = Phim::with(['danhGia.nguoiDung', 'suatChieu.phongChieu', 'theLoai'])->find($phim_id);
        return view('pages.detail', compact('phim'));
    }
}
