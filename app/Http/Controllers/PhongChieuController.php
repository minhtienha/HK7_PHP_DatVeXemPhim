<?php

namespace App\Http\Controllers;

use App\Models\PhongChieu;
use Illuminate\Http\Request;

class PhongChieuController extends Controller
{
    public function index()
    {
        $phongs = PhongChieu::all();
        return view('phong_chieu.index', compact('phongs'));
    }

    public function show($id)
    {
        $phong = PhongChieu::find($id);
        return view('phong_chieu.show', compact('phong'));
    }
}
