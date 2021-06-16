<?php

namespace App\Http\Controllers;

use App\GiangVien;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class GiangVienController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lst_giangvien = GiangVien::where('trangthai','<>',0)->with('bomon')->paginate(10);

        return response()->json(['status' => 'success','data' => $lst_giangvien],200);
    }

    public function getAll()
    {
        $lst_giangvien = GiangVien::where('trangthai','<>',0)->get();

        return response()->json(['status' => 'success','data' => $lst_giangvien],200);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'email' => $request->msgv.'@caothang.edu.vn',
            'trangthai' => 1,
            'password'  => Hash::make($request->cccd),
            'role'      => 1
        ]);

        if (!empty($user)) {
            $gv = GiangVien::create([
                'msgv'  => $request->msgv,
                'hogv' => $request->hogv,
                'tengv' => $request->tengv,
                'ngaysinh' => $request->ngaysinh,
                'gioitinh' => $request->gioitinh,
                'sdt' => $request->sdt,
                'cccd' => $request->cccd,
                'matk' => $user->id,
                'mabm' => $request->bomon,
                'province_id' => $request->tinh,
                'district_id' => $request->huyen,
                'ward_id' => $request->xa,
                'trangthai' => 1,

            ]);
            if (!empty($gv)) {
                return response()->json(['status' => 'success', 'message' => 'Thêm thành công','data' => $gv->id], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại'], 403);
        }
    }

    public function show($id)
    {
        $sv = GiangVien::where('id',$id)->with('bomon', 'taikhoan','lophocphans' ,'tinh', 'huyen', 'xa')->first();
        if (!empty($sv))
            return response()->json(['status' => 'success', 'data' => $sv], 200);
    }

    public function update(Request $request, $id)
    {
        $gv = GiangVien::find($id);
        $gv->update([
            'hogv' => $request->hogv,
            'tengv' => $request->tengv,
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'sdt' => $request->sdt,
            'cccd' => $request->cccd,
            'mabm' => $request->bomon,
            'province_id' => $request->tinh,
            'district_id' => $request->huyen,
            'ward_id' => $request->xa,

        ]);
        if (!empty($gv)) {
            return response()->json(['status' => 'success', 'message' => 'Sửa thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Sửa thất bại'], 403);
    }

    public function destroy($id)
    {
        $gv = GiangVien::find($id);
        if (!empty($gv)) {
            if ($gv->trangthai == 0) {
                return response()->json(['status' => 'error', 'message' => 'Giảng viên đã bị xóa'], 403);
            } else {
                $gv->trangthai = 0;
                $gv->save();
                return response()->json(['status' => 'success', 'message' => 'Xóa thành công'], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Giảng viên không tồn tại'], 404);
        }
    }
    public function timkiemGV(Request $request){
        if($request->key_word == null){
            $lst_gv = GiangVien::where('trangthai', '<>', 0)->with('bomon')->paginate(10);
            if (!empty($lst_gv))
                return response()->json(['status' => 'success', 'data' => $lst_gv], 200);
        }
        else{
            $lst_gv = GiangVien::where('hogv','like','%'.$request->key_word.'%')
            ->orWhere('tengv','like','%'.$request->key_word.'%');
            if (!empty($lst_gv))
                return response()->json(['status' => 'success', 'data' => $lst_gv->where('trangthai','<>',0)->with('bomon')->paginate(10)], 200);
        }
    }
    
}
