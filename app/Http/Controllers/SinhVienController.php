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
    public function store(Request $request)
    {
     
        $sv =SinhVien::create([
            'hosv' => $request->hosv,
            'tensv' => $request->tensv,
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'sdt' => $request->sdt,
            'cccd' => $request->cccd,
            'malh' => $request->lop,
            'province_id' => $request->tinh,
            'district_id' => $request->huyen,
            'ward_id' => $request->xa,
            'trangthai' => 1,

        ]);
        if(!empty($sv)){
            return response()->json(['status'=>'success','message'=>'Thêm thành công'],200);
        }
        return response()->json(['status'=>'error','message'=>'Thêm thất bại'],403);
    }
    public function update(Request $request,$id)
    {
        $sv = SinhVien::find($id);
        $sv->update([
            'hosv' => $request->hosv,
            'tensv' => $request->tensv,
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'sdt' => $request->sdt,
            'cccd' => $request->cccd,
            'malh' => $request->lop,
            'province_id' => $request->tinh,
            'district_id' => $request->huyen,
            'ward_id' => $request->xa,
            'trangthai' => 1,

        ]);
        if(!empty($sv)){
            return response()->json(['status'=>'success','message'=>'Sửa thành công'],200);
        }
        return response()->json(['status'=>'error','message'=>'Sửa thất bại'],403);
    }
}
