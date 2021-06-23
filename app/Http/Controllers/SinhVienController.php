<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SinhVien;
use App\User;
use Illuminate\Support\Facades\Hash;

class SinhVienController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index()
    {
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->with('lophoc')->paginate(10);

        if (!empty($lst_sv))
            return response()->json(['status' => 'success', 'data' => $lst_sv], 200);
    }

    public function getAll()
    {
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->get();

        if (!empty($lst_sv))
            return response()->json(['status' => 'success', 'data' => $lst_sv], 200);
    }
    public function show(Request $request, $id)
    {
        $sv = SinhVien::where([['id', $id]])->with('lophoc', 'taikhoan', 'tinh', 'huyen', 'xa')->first();
        if (!empty($sv))
            return response()->json(['status' => 'success', 'data' => $sv], 200);
    }
    public function store(Request $request)
    {

        $user = User::create([
            'email' => $request->mssv.'@caothang.edu.vn',
            'trangthai' => 1,
            'password'  => Hash::make($request->cccd)
        ]);

        if (!empty($user)) {
            $sv = SinhVien::create([
                'mssv'  =>$request->mssv,
                'hosv' => $request->hosv,
                'tensv' => $request->tensv,
                'ngaysinh' => $request->ngaysinh,
                'gioitinh' => $request->gioitinh,
                'sdt' => $request->sdt,
                'cccd' => $request->cccd,
                'matk' => $user->id,
                'malh' => $request->lop,
                'province_id' => $request->tinh,
                'district_id' => $request->huyen,
                'ward_id' => $request->xa,
                'trangthai' => 1,

            ]);
            if (!empty($sv)) {
                return response()->json(['status' => 'success', 'message' => 'Thêm thành công','data'=>$sv->id], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại'], 403);
        }
    }
    public function update(Request $request, $id)
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

        ]);
        if (!empty($sv)) {
            return response()->json(['status' => 'success', 'message' => 'Sửa thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Sửa thất bại'], 403);
    }
    public function destroy($id)
    {
        $sinhvien = SinhVien::find($id);
        if (!empty($sinhvien)) {
            if ($sinhvien->trangthai == 0) {
                return response()->json(['status' => 'error', 'message' => 'Sinh viên đã bị xóa'], 403);
            } else {
                $sinhvien->trangthai = 0;
                $sinhvien->save();
                return response()->json(['status' => 'success', 'message' => 'Xóa thành công'], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sinh viên không tồn tại'], 404);
        }
    }
    public function lock($id)
    {
        // $sinhvien = SinhVien::find($id);
        // if (!empty($sinhvien)) {
        //     if ($sinhvien->trangthai == 2) {
        //         return response()->json(['status' => 'error', 'message' => 'Sinh viên đã khóa'], 403);
        //     } else {
        //         $lst_sv = SinhVien::where('trangthai', '<>', 0)->paginate(10);
        //         $sinhvien->save();
        //         return response()->json(['status' => 'success', 'message' => 'Khóa thành công','data'=>$lst_sv], 200);
        //     }
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sinh viên không tồn tại'], 404);
        // }
        // return response()->json(['status' => 'success', 'message' => $id]);
        $sinhvien = SinhVien::where('id',$id)->first();
        
        $sinhvien->trangthai = 2;
        $sinhvien->save();
        // $lst_gv = GiangVien::where('trangthai', 1)->get();
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã khóa", 'data'=>$lst_sv], 200);
    }
    public function unlock($id)
    {
        // $sinhvien = SinhVien::find($id);
        // if (!empty($sinhvien)) {
        //     if ($sinhvien->trangthai == 1) {
        //         return response()->json(['status' => 'error', 'message' => 'Sinh viên không bị khóa'], 403);
        //     } else {
        //         $lst_sv = SinhVien::where('trangthai', '<>', 0)->paginate(10);
        //         $sinhvien->save();
        //         return response()->json(['status' => 'success', 'message' => 'Mở khóa thành công', 'data'=>$lst_sv], 200);
        //     }
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sinh viên không tồn tại'], 404);
        // }
        $sinhvien = SinhVien::find($id);
        $sinhvien->trangthai = 1;
        $sinhvien->save();
        // $lst_gv = GiangVien::where('trangthai', 2)->get();
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã mở khóa", 'data'=>$lst_sv], 200);

    }
    public function timkiemSV(Request $request){
        if($request->key_word == null){
            $lst_sv = SinhVien::where('trangthai', '<>', 0)->paginate(10);
            if (!empty($lst_sv))
                return response()->json(['status' => 'success', 'data' => $lst_sv], 200);
        }
        else{
            $lst_sv = SinhVien::where('hosv','like','%'.$request->key_word.'%')
            ->orWhere('tensv','like','%'.$request->key_word.'%');
            if (!empty($lst_sv))
                return response()->json(['status' => 'success', 'data' => $lst_sv->where('trangthai','<>',0)->paginate(10)], 200);
        }
    }
    public function getThongTin($id)
    {
        $sv = SinhVien::where([['mssv', $id]])->with('lophoc')->first();
        if (!empty($sv))
            return response()->json(['status' => 'success', 'data' => $sv], 200);
    }
}
