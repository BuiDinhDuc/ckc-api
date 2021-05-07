<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SinhVien;


class SinhVienController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function getAllSinhVien(Request $request)
    {
        $lst_sv = SinhVien::all();

        if (!empty($lst_sv))
            return response()->json(['status' => 'success', 'data' => $lst_sv], 200);
    }
    public function detail(Request $request, $id)
    {
        $sv = SinhVien::where([['id', $id]])->with('lophoc', 'taikhoan', 'tinh', 'huyen', 'xa')->first();
        if (!empty($sv))
            return response()->json(['status' => 'success', 'data' => $sv], 200);
    }
}
