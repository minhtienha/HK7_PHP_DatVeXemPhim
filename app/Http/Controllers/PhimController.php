<?php

namespace App\Http\Controllers;
use App\Models\Phim; 
use App\Models\TheLoai;


use Illuminate\Http\Request;

class PhimController extends Controller
{
    public function index()
    {
        $phims = Phim::with('theLoais')->get();

        // Nếu file là resources/views/phim/index.blade.php
        return view('phim.index', compact('phims'));
    }

    public function show($id)
    {
        $phim = Phim::find($id);
        return view('phim.show', compact('phim'));
    }
}