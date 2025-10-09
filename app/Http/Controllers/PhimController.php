<?php

namespace App\Http\Controllers;

use App\Models\Phim;
use Illuminate\Http\Request;

class PhimController extends Controller
{
    public function index()
    {
        $phims = Phim::all();
        return view('phim.index', compact('phims'));
    }

    public function show($id)
    {
        $phim = Phim::find($id);
        return view('phim.show', compact('phim'));
    }
}
