<?php

namespace App\Http\Controllers;

use App\Models\Ve;
use Illuminate\Http\Request;

class VeController extends Controller
{
    public function index()
    {
        $ves = Ve::all();
        return view('ve.index', compact('ves'));
    }

    public function show($id)
    {
        $ve = Ve::find($id);
        return view('ve.show', compact('ve'));
    }
}
