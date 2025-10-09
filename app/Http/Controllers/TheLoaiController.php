<?php

namespace App\Http\Controllers;

use App\Models\TheLoai;
use Illuminate\Http\Request;

class TheLoaiController extends Controller
{
    public function index()
    {
        $theLoais = TheLoai::all();
        return view('the_loai.index', compact('theLoais'));
    }

    public function show($id)
    {
        $theLoai = TheLoai::find($id);
        return view('the_loai.show', compact('theLoai'));
    }
}
