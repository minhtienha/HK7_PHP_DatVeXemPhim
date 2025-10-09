<?php

namespace App\Http\Controllers;

use App\Models\GheNgoi;
use Illuminate\Http\Request;

class GheNgoiController extends Controller
{
    public function index()
    {
        $ghes = GheNgoi::all();
        return view('ghe_ngoi.index', compact('ghes'));
    }

    public function show($id)
    {
        $ghe = GheNgoi::find($id);
        return view('ghe_ngoi.show', compact('ghe'));
    }
}
