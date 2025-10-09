<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;

class NguoiDungController extends Controller
{
    public function index()
    {
        $users = NguoiDung::all();
        return view('nguoi_dung.index', compact('users'));
    }

    public function show($id)
    {
        $user = NguoiDung::find($id);
        return view('nguoi_dung.show', compact('user'));
    }
}
