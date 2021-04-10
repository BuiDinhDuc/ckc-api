<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SinhVien;


class SinhVienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getListSV(Request $request)
    {
        $lst_sv = SinhVien::where('trangthai', 1)->get();
    }
}
